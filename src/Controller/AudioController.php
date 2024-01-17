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
        $form = $this->createForm(AudioType::class, $audio);

        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $emissionId = $request->query->get('emission');
        
        if ($emissionId) {
            $emission = $entityManager->getRepository(Emission::class)->find($emissionId);
            
            if ($emission) {
                $form->get('IDEMISSION')->setData($emission);
            }

            // get the file and move it to the right directory
            // the file name is the NOM emission / NOM audio.wav
            $file = $request->files->get('audio')['FILE'];
            $fileName = $emission->getNOM() . '/' . $audio->getNOM() . '.wav';
            
            $file->move($this->audioDir, $fileName);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($audio);
            $entityManager->flush();

            return $this->redirectToRoute('app_audio_index', [], Response::HTTP_SEE_OTHER);
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
        $form = $this->createForm(AudioType::class, $audio);
        $form->handleRequest($request);

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($form->isSubmitted() && $form->isValid()) {
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

        if ($this->isCsrfTokenValid('delete'.$audio->getId(), $request->request->get('_token'))) {
            $entityManager->remove($audio);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_audio_index', [], Response::HTTP_SEE_OTHER);
    }
}
