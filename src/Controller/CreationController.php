<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


use App\Entity\Emission;
use App\Entity\Audio;
use App\Form\EmissionType;
use App\Form\AudioType;

class CreationController extends AbstractController
{
    #[Route('/creation', name: 'app_creation')]
    public function index(Request $request): Response
    {
        $emission = new Emission();
        $audio = new Audio();

        $formEmission = $this->createForm(EmissionType::class, $emission);
        $formAudio = $this->createForm(AudioType::class, $audio);

        $formEmission->handleRequest($request);
        $formAudio->handleRequest($request);

        if ($formEmission->isSubmitted() && $formEmission->isValid()) {
            
        }
    }
}
