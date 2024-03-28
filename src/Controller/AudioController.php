<?php

namespace App\Controller;

use App\Entity\Emission;
use App\Entity\Audio;
use App\Form\AudioType;
use App\Repository\AudioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/audio')]
class AudioController extends AbstractController
{
    private $audioDir;

    // set le chemin du dossier audio recup depuis services.yaml
    public function __construct(string $audioDir)
    {
        $this->audioDir = $audioDir;
    }

    #[Route('/', name: 'app_audio_index', methods: ['GET'])]
    public function index(AudioRepository $audioRepository): Response
    {
        return $this->render('audio/index.html.twig', [
            'audio' => $audioRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_audio_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $audio = new Audio();

        $form = $this->createForm(AudioType::class, $audio, [
            'dir' => $this->audioDir
        ]);

        $form->handleRequest($request);

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $emissionId = $request->query->get('emission');

        if ($emissionId) {

            $emission = $entityManager->getRepository(Emission::class)->find($emissionId);
            $form->get('IDEMISSION')->setData($emission);
        }


        if ($form->isSubmitted() && $form->isValid()) {

            $audiof = $form->get('AUDIO')->getData();

            if ($audiof) {
                $newFilename = $audio->getNOM() . ".wav";

                try {
                    $audiof->move(
                        $this->audioDir . '/' . $audio->getIDEMISSION()->getNOM() . '/',
                        $newFilename
                    );
                } catch (FileException $e) {
                    dump($e);
                }
            }

            $audio->setAUDIO($audio->getIDEMISSION()->getNOM() . '/' . $newFilename);

            $entityManager->persist($audio);
            $entityManager->flush();

            return $this->redirectToRoute('app_creation', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('audio/new.html.twig', [
            'audio' => $audio,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_audio_show', methods: ['GET'])]
    public function show(Audio $audio): Response
    {
        return $this->render('audio/show.html.twig', [
            'audio' => $audio,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_audio_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Audio $audio, EntityManagerInterface $entityManager): Response
    {
        // Recuperer le nom du fichier 
        $oldAudio = $audio->getNOM();

        // Creer le form avec un param
        $form = $this->createForm(AudioType::class, $audio, [
            'dir' => $this->audioDir
        ]);
        $form->handleRequest($request);

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($form->isSubmitted() && $form->isValid()) {

            // Recuperer le nouveau nom du fichier
            $newAudio = $audio->getNOM();

            // creer la dir avec le nom de l'emission
            $dir = $this->audioDir . '/' . $audio->getIDEMISSION()->getNOM() . '/';

            // recup le fichier audio
            $audiof = $form->get('AUDIO')->getData();

            // si fichier
            if ($audiof) {
                $newFilename = $audio->getNOM() . ".wav";

                try {

                    // dl l'audio
                    $audiof->move(
                        $dir,
                        $newFilename
                    );

                    // 
                    if (file_exists($dir . $oldAudio . '.wav')) {
                        unlink($dir . $oldAudio . '.wav');
                    }
                } catch (FileException $e) {
                    dump($e);
                }


                $audio->setAUDIO($audio->getIDEMISSION()->getNOM() . '/' . $newAudio . '.wav');
            
                // sinon garder l'ancien audio
            } else {
                $audio->setAUDIO($audio->getIDEMISSION()->getNOM() . '/' . $oldAudio . '.wav');
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_creation', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('audio/edit.html.twig', [
            'audio' => $audio,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_audio_delete', methods: ['POST'])]
    public function delete(Request $request, Audio $audio, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete' . $audio->getId(), $request->request->get('_token'))) {
            $entityManager->remove($audio);
            $entityManager->flush();

            // Suppression du fichier audio

            $dir = $this->audioDir . '/' . $audio->getIDEMISSION()->getNOM() . '/';
            $audioPath = $dir . $audio->getNOM() . '.wav';

            unlink($audioPath);
        }

        return $this->redirectToRoute('app_creation', [], Response::HTTP_SEE_OTHER);
    }
}
