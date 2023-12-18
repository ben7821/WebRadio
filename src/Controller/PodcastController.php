<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class PodcastController extends AbstractController
{
    #[Route('/podcast', name: 'app_podcast')]
    public function index(): Response
    {
        return $this->render('podcast/index.html.twig', [
            'controller_name' => 'PodcastController',
        ]);
    }

    #[Route('/podcast', name: 'app_audio')]
    public function getDossierPodcast(KernelInterface $kernel): Response {
        $file = $kernel->getProjectDir().'/data/audio';
        
        return $this->render('podcast/index.html.twig', [
            'podcasts' => 'podcasts',
        ]);
    }

    #[Route('/podcast', name: 'app_recup_audio')]
    public function RecuperationPodcast(): Response {

        return $this->render('podcast/show_audio.html.twig', [
            'podcasts' => 'podcasts',
        ]);
    }
}
