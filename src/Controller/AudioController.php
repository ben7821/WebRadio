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
        $oldAudio = $audio->getNOM();

        $form = $this->createForm(AudioType::class, $audio, [
            'dir' => $this->audioDir
        ]);
        $form->handleRequest($request);

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($form->isSubmitted() && $form->isValid()) {
            
            $newAudio = $audio->getNOM();

            if ($newAudio != $oldAudio) {
                rename($this->audioDir . '/' . $audio->getIDEMISSION()->getNOM() . '/' . $oldAudio . '.wav', $this->audioDir . '/' . $audio->getIDEMISSION()->getNOM() . '/' . $newAudio . '.wav');
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_audio_index', [], Response::HTTP_SEE_OTHER);
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
        }

        return $this->redirectToRoute('app_audio_index', [], Response::HTTP_SEE_OTHER);
    }
}
