<?php

namespace App\Controller;

use App\Entity\Emission;
use App\Entity\Inscription;
use App\Entity\Participant;
use App\Form\EmissionType;
use App\Form\ParticipantType;
use App\Repository\EmissionRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;


#[Route('/emission')]
class EmissionController extends AbstractController
{
    private $emissionDir;
    private $audioDir;

    // Set les chemin depuis services.yaml
    public function __construct(string $emissionDir, string $audioDir)
    {
        $this->emissionDir = $emissionDir;
        $this->audioDir = $audioDir;
    }

    #[Route('/', name: 'app_emission_index', methods: ['GET'])]
    public function index(EmissionRepository $emissionRepository): Response
    {
        return $this->render('emission/index.html.twig', [
            'emissions' => $emissionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_emission_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $emission = new Emission();

        // Creer le form avec un param
        $form = $this->createForm(EmissionType::class, $emission, [
            'dir' => $this->emissionDir
        ]);
        $form->handleRequest($request);

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($form->isSubmitted() && $form->isValid()) {
            dd($form->get('IMG')->getData());            
            // recup l'img
            $img = $form->get('IMG')->getData();

            // si l'img
            if ($img) {
                $imageFileName = $emission->getNom() . '.png';
                //$imageFileName = "";
                                
                try {

                    // dl l'img
                    $img->move(
                        $this->emissionDir . '/',
                        $imageFileName
                    );
                } catch (FileException $e) {
                    dump($e);
                }

                $emission->setIMG($imageFileName);

                $entityManager->persist($emission);
                $entityManager->flush();
                }
            // sinon, pas d'img
             else {

                // set le default
                $emission->setIMG('default.png');

                $entityManager->persist($emission);
                $entityManager->flush();
            }

            // creer le dossier dans les datas
            $folder = $this->audioDir ."/". $emission->getNom();
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }

            return $this->redirectToRoute('app_creation', [], Response::HTTP_SEE_OTHER);
        }
    
       
        
        return $this->renderForm('emission/new.html.twig', [
            'emission' => $emission,
            'form' => $form,
        ]);
    }

    #[Route('/{NOM}', name: 'app_emission_show', methods: ['GET', 'POST'])]
    public function show(Request $request, Emission $emission, EntityManagerInterface $entityManager): Response
    {
        $participant = new Participant();

        // Creer le form avec un type participant
        $form = $this->createForm(ParticipantType::class);
        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {

            // si on delete dans la page edit
            if($this->isCsrfTokenValid('delete' . $emission->getID(), $request->request->get('_token'))) {
                $entityManager->remove($emission);
                $entityManager->flush();
            }
            
            // get le result du formulaire
            $data = $request->request->all('participant');
            // recup l'objet avec l'id pour le set
            $inscription = $entityManager->getRepository(Inscription::class)->find($data['Inscription']);

            // set les datas
            $participant->setInscription($inscription);
            $participant->setPRENOM($data['PRENOM']);
            $participant->setNOM($data['NOM']);
            $participant->setMAIL($data['MAIL']);
            $participant->setTEL($data['TEL']);
            
            $entityManager->persist($participant);
            
            $entityManager->flush();

            return $this->redirectToRoute('app_emission_show', ['NOM' => $emission->getNom()]);
        }
        return $this->renderForm('emission/show.html.twig', [
            'emission' => $emission,
            'audios' => $emission->getAudio(),
            'inscriptions' => $emission->getInscriptions(),
            'form' => $form
        ]);
    }

    #[Route('/{ID}/edit', name: 'app_emission_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Emission $emission, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $oldName = $emission->getNom();
        dd($emission->getIMG());
        // Creer le form avec un param
        $form = $this->createForm(EmissionType::class, $emission, [
            'dir' => $this->emissionDir
        ]);

        $form->handleRequest($request);

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($form->isSubmitted() && $form->isValid()) {
            
            // set les noms des folders
            $oldFolder = $this->audioDir ."/". $oldName;
            $newFolder = $this->audioDir ."/". $emission->getNom();

            // si different, rename le dossier
            if ($oldFolder !== $newFolder) {
                rename($oldFolder, $newFolder);
            }
            
            // get l'img
            $imgFile = $form->get('IMG')->getData();
            
            // si img
            if ($imgFile) {
                $originalFilename = pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME);
                
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imgFile->guessExtension();

                //$newFilename = $emission->getNom() . '.png';
                
                try {
                    
                    // dl l'img
                    $imgFile->move(
                        $this->getParameter('image_dir'),
                        $newFilename
                    );
                    //$imgFile->move($this->emissionDir."/", $newFilename);
                    //$emission->setIMG($newFilename);
                    
                    // delete l'ancienne
                    // $oldFilename = $this->emissionDir . '/' . $oldName . '.png';
                    // if (file_exists($oldFilename)) {
                    //     unlink($oldFilename);
                    // }
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors du déplacement de l\'image.');
                }
                $emission->setIMG($newFilename);

            // si pas img
            } else {
                $emission->setIMG($oldName . '.png');
            }

            $entityManager->persist($emission);
            $entityManager->flush();

            // return $this->redirectToRoute('app_creation', [], Response::HTTP_SEE_OTHER);
        }


        return $this->renderForm('emission/edit.html.twig', [
            'emission' => $emission,
            'form' => $form,
        ]);
    }

    #[Route('/{ID}/delete', name: 'app_emission_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, Emission $emission, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete' . $emission->getID(), $request->request->get('_token'))) {
            $entityManager->remove($emission);
            $entityManager->flush();

            // si le dossier existe, le delete
            $folder = $this->audioDir ."/". $emission->getNom();
            if (file_exists($folder)) {
                rmdir($folder);
            }

            // remove l'img
            $filename = $this->emissionDir . '/' . $emission->getNom() . '.png';
            if (file_exists($filename)) {
                unlink($filename);
            }
        }

        return $this->redirectToRoute('app_creation', [], Response::HTTP_SEE_OTHER);
    }
}
