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
        $podcast = $this->recuperationPodcast();
        return $this->render('podcast/index.html.twig', [
            'controller_name' => 'PodcastController',
            'podcast' => 'lesPodcasts',
        ]);
    }

    #[Route('/podcast', name: 'app_audio')]
    public function recuperationPodcast(): Response {
        $path = 'data/audio/';
        $files = scandir($path);
        $content = '';
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $content .= file_get_contents($path . $file);
            }
        }
        return $this->render('podcast/index.html.twig', [
            'podcasts' => 'LesPodcasts',
        ]);
    }

}
