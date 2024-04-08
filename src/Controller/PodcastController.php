<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

///////////////////////////////////////////////
/// PodcastController
/// Gestion des podcasts
///////////////////////////////////////////////
class PodcastController extends AbstractController
{

    /// ------------------------------------------
    /// index
    /// Affiche la page des podcasts
    /// ------------------------------------------
    #[Route('/podcast', name: 'app_podcast')]
    public function index(): Response
    {
        $podcast = $this->recuperationAudio();
        return $this->render('podcast/index.html.twig', [
            //'controller_name' => 'PodcastController',
            'podcasts' => 'lesPodcasts',
        ]);
    }

    /// ------------------------------------------
    /// recuperationAudio
    /// Récupère les fichiers audio dans le dossier data/audio, les trie et les affiche
    /// ------------------------------------------
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
