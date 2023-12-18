<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


use App\Entity\Emission;
use App\Entity\Audio;

class CreationController extends AbstractController
{
    #[Route('/creation', name: 'app_creation')]
    public function index(EntityManagerInterface $em): Response
    {


        $emission = $em->getRepository(Emission::class)->findAll();
        $audio = $em->getRepository(Audio::class)->findAll();

        return $this->render('creation/index.html.twig', [
            'controller_name' => 'CreationController',
            'emissions' => $emission,
            'audios' => $audio,
        ]);
    }

    #[Route('/creation/{ID}', name: 'app_creation_show')]
    public function showAudios(EntityManagerInterface $em, $ID): Response
    {
        $emission = $em->getRepository(Emission::class)->find($ID);
        
        if (!$emission) {
            throw $this->createNotFoundException(
                'No product found for id '.$ID
            );
        }

        $audio = $emission->getAudio();

        return $this->render('creation/index.html.twig', [
            'controller_name' => 'CreationController',
            'emissions' => $emission,
            'audios' => $audio,
        ]);
    }
}
