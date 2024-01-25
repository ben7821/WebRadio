<?php

namespace App\Controller;

use App\Entity\Emission;
use App\Form\EmissionType;
use App\Form\ParticipantType;
use App\Repository\EmissionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/emission')]
class EmissionController extends AbstractController
{
    private $emissionDir;
    private $audioDir;

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
        $form = $this->createForm(EmissionType::class, $emission, [
            'dir' => $this->emissionDir
        ]);
        $form->handleRequest($request);

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($form->isSubmitted() && $form->isValid()) {

            $img = $form->get('IMG')->getData();

            if ($img) {
                $newFilename = $emission->getNom() . '.png';

                try {
                    $img->move(
                        $this->emissionDir . '/',
                        $newFilename
                    );
                } catch (FileException $e) {
                    dump($e);
                }

                $emission->setIMG($newFilename);

                $entityManager->persist($emission);
                $entityManager->flush();
            } else {
                $emission->setIMG('default.png');

                $entityManager->persist($emission);
                $entityManager->flush();
            }

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

    #[Route('/{NOM}', name: 'app_emission_show', methods: ['GET'])]
    public function show(Request $request, Emission $emission): Response
    {
        $form = $this->createForm(ParticipantType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $entityManager->persist($inscription);
            // $entityManager->flush();

            return $this->redirectToRoute('app_emission_show', ['NOM' => $emission->getNom()]);
        }
        return $this->render('emission/show.html.twig', [
            'emission' => $emission,
            'audios' => $emission->getAudio(),
            'inscriptions' => $emission->getInscriptions(),
            'form' => $form->createView()
        ]);
    }

    #[Route('/{ID}/edit', name: 'app_emission_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Emission $emission, EntityManagerInterface $entityManager): Response
    {
        $oldName = $emission->getNom();

        $form = $this->createForm(EmissionType::class, $emission, [
            'dir' => $this->emissionDir
        ]);
        $form->handleRequest($request);

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($form->isSubmitted() && $form->isValid()) {
            $oldFolder = $this->audioDir ."/". $oldName;
            $newFolder = $this->audioDir ."/". $emission->getNom();

            
            if ($oldFolder !== $newFolder) {
                rename($oldFolder, $newFolder);
            }
            
            $imgFile = $form->get('IMG')->getData();
            
            if ($imgFile) {
                
                $newFilename = $emission->getNom() . '.png';
                
                try {
                    
                    $imgFile->move($this->emissionDir."/", $newFilename);
                    $emission->setIMG($newFilename);
                    
                    $oldFilename = $this->emissionDir . '/' . $oldName . '.png';
                    if (file_exists($oldFilename)) {
                        unlink($oldFilename);
                    }
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors du déplacement de l\'image.');
                }
            } else {
                $emission->setIMG($oldName . '.png');
            }

            $entityManager->persist($emission);
            $entityManager->flush();

            return $this->redirectToRoute('app_creation', [], Response::HTTP_SEE_OTHER);
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

            $folder = $this->audioDir ."/". $emission->getNom();
            if (file_exists($folder)) {
                rmdir($folder);
            }

            $filename = $this->emissionDir . '/' . $emission->getNom() . '.png';
            if (file_exists($filename)) {
                unlink($filename);
            }
        }

        return $this->redirectToRoute('app_creation', [], Response::HTTP_SEE_OTHER);
    }
}
