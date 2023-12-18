<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Emission;
use App\Entity\Audio;

class CreationController extends AbstractController
{
    #[Route('/creation', name: 'app_creation')]
    public function index(): Response
    {
        $emission = $this->getDoctrine()->getRepository(Emission::class)->findAll();
        $audio = $this->getDoctrine()->getRepository(Audio::class)->findAll();
            
        return $this->render('creation/index.html.twig', [
            'controller_name' => 'CreationController',
            'emission' => $emission,
            'audio' => $audio,
        ]);
    }
}
