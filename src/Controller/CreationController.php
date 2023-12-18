<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


use App\Entity\Emission;
use App\Entity\Audio;

class CreationController extends AbstractController
{
    #[Route('/creation', name: 'app_creation')]
    public function index(Request $request): Response
    {


        $emission = $container->get('doctrine')->getRepository(Emission::class)->findAll();

        $audio = $doctrine->getRepository(Audio::class)->findAll();

        return $this->render('creation/index.html.twig', [
            'controller_name' => 'CreationController',
            'emissions' => $emission,
            'audios' => $audio,
        ]);
    }
}
