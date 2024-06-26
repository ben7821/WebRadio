<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Form\EquipeType;
use App\Repository\EquipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

///////////////////////////////////////////////
// EquipeController
// Gestion de l'equipe
///////////////////////////////////////////////
#[Route('/equipe')]
class EquipeController extends AbstractController
{

    /// Chemin du dossier des equipes
    private string $equipeDir;

    // Recuperer le chemin depuis services.yaml
    public function __construct(string $equipeDir)
    {
        $this->equipeDir = $equipeDir;
    }

    /// ------------------------------------------
    /// index
    /// Affiche la page d'accueil de l'equipe
    /// ------------------------------------------
    #[Route('/', name: 'app_equipe_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('equipe/index.html.twig', [
            'controller_name' => 'EquipeController',
        ]);
    }

    /// ------------------------------------------
    /// getAllMembres
    /// Recupere tous les membres de l'equipe
    /// ------------------------------------------
    #[Route('/membres', name: 'app_membres_index')]
    public function getAllMembres(EntityManagerInterface $entityManager): Response
    {
        $membres = $entityManager->getRepository(Equipe::class)->findAll();
        return $this->render('equipe/membres.html.twig', [
            'membres' => $membres,
        ]);
    }

    /// ------------------------------------------
    /// renderLycee
    /// Affiche la page du lycee
    /// ------------------------------------------
    #[Route('/lycee', name: 'app_lycee_index')]
    public function renderLycee(EntityManagerInterface $entityManager)
    {
        return $this->render('equipe/lycee.html.twig', [
            'controller_name' => 'EquipeController',
        ]);
    }

    /// ------------------------------------------
    /// new
    /// Affiche la page de l'equipe
    /// ------------------------------------------
    #[Route('/new', name: 'app_equipe_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $equipe = new Equipe();

        // Creer le form avec un param
        $form = $this->createForm(EquipeType::class, $equipe, [
            "dir" => $this->equipeDir
        ]);

        $form->handleRequest($request);

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($form->isSubmitted() && $form->isValid()) {

            // recup l'img
            $file = $form->get('IMG')->getData();

            // si img
            if ($file) {
                $fileName = $equipe->getNOM() . '_' . $equipe->getPRENOM() . '.png';

                try {

                    // dl l'img
                    $file->move(
                        $this->equipeDir . '/',
                        $fileName
                    );
                } catch (FileException $e) {
                    dump($e);
                }

                $equipe->setIMG($fileName);
            }


            $entityManager->persist($equipe);
            $entityManager->flush();

            return $this->redirectToRoute('app_equipe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('equipe/new.html.twig', [
            'equipe' => $equipe,
            'form' => $form,
        ]);
    }

    /// ------------------------------------------
    /// show
    /// Affiche la page d'un membre de l'equipe
    /// ------------------------------------------
    #[Route('/{id}', name: 'app_equipe_show', methods: ['GET'])]
    public function show(Equipe $equipe): Response
    {
        return $this->render('equipe/show.html.twig', [
            'equipe' => $equipe,
        ]);
    }

    /// ------------------------------------------
    /// edit
    /// Affiche la page d'edition d'un membre de l'equipe
    /// ------------------------------------------
    #[Route('/{id}/edit', name: 'app_equipe_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Equipe $equipe, EntityManagerInterface $entityManager): Response
    {
        $oldName = $equipe->getNOM() . '_' . $equipe->getPRENOM() . '.png';

        // Creer le form avec un param
        $form = $this->createForm(EquipeType::class, $equipe, [
            "dir" => $this->equipeDir
        ]);
        $form->handleRequest($request);

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($form->isSubmitted() && $form->isValid()) {
            
            // get l'img
            $file = $form->get('IMG')->getData();
            
            // si img
            if ($file) {
                $fileName = $equipe->getNOM() . '_' . $equipe->getPRENOM() . '.png';

                try {

                    // dl l'img
                    $file->move(
                        $this->equipeDir . '/',
                        $fileName
                    );
                    
                    // delete l'ancienne
                    if (file_exists($this->equipeDir . '/' . $oldName)) {
                        unlink($this->equipeDir . '/' . $oldName);
                    }
                } catch (FileException $e) {
                    dump($e);
                }
                
                $equipe->setIMG($fileName);

            // si pas img
            } else {
                $equipe->setIMG($oldName);
            }
            
            $entityManager->flush();
            
            return $this->redirectToRoute('app_creation', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('equipe/edit.html.twig', [
            'equipe' => $equipe,
            'form' => $form,
        ]);
    }

    /// ------------------------------------------
    /// delete
    /// Supprime un membre de l'equipe
    /// ------------------------------------------
    #[Route('/{id}', name: 'app_equipe_delete', methods: ['POST'])]
    public function delete(Request $request, Equipe $equipe, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete' . $equipe->getId(), $request->request->get('_token'))) {
            // delete
            $entityManager->remove($equipe);
            $entityManager->flush();

            // recup le nom du fichier
            $fileName = $equipe->getNOM() . '_' . $equipe->getPRENOM() . '.png';

            // delete l'img
            if (file_exists($this->equipeDir . '/' . $fileName)) {
                unlink($this->equipeDir . '/' . $fileName);
            }
        }

        return $this->redirectToRoute('app_creation', [], Response::HTTP_SEE_OTHER);
    }
}
