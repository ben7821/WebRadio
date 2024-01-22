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
        $podcast = $this->recuperationAudio();
        return $this->render('podcast/index.html.twig', [
            //'controller_name' => 'PodcastController',
            'podcasts' => 'lesPodcasts',
        ]);
    }

    #[Route('/podcast', name: 'app_audio')]
    public function recuperationAudio(): Response {
        $path = 'data/audio/';
        $files = scandir($path);
        $audio_files = array_filter($files, function($file) {
            return pathinfo($file, PATHINFO_EXTENSION) === 'wav';
        });
        return $this->render('podcast/index.html.twig', [
            'podcasts' => 'LesPodcasts',
        ]);
    }

    


}
