<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


use App\Entity\Emission;
use App\Entity\Audio;
use App\Entity\Equipe;
use App\Entity\Inscription;
use App\Entity\Participant;
use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreationController extends AbstractController
{
    #[Route('/admin/creation', name: 'app_creation')]
    public function index(EntityManagerInterface $em): Response
    {
        //dd($this->getUser()->getRoles());

        // recup toute les datas a gerer

        $emission = $em->getRepository(Emission::class)->findAll();
        $audio = $em->getRepository(Audio::class)->findAll();
        $inscription = $em->getRepository(Inscription::class)->findAll();

        if ($this->getUser()->getRoles()[0] == "ROLE_ADMIN") {


            $utilisateur = $em->getRepository(Utilisateur::class)->findAll();
            $participant = $em->getRepository(Participant::class)->findAll();
            $membres = $em->getRepository(Equipe::class)->findAll();


            return $this->render('creation/index.html.twig', [
                'controller_name' => 'CreationController',
                'emissions' => $emission,
                'audios' => $audio,
                'membres' => $membres,
                'inscriptions' => $inscription,
                'participants' => $participant,
                'utilisateurs' => $utilisateur,
                'admin' => true
            ]);
        }

        return $this->render('creation/index.html.twig', [
            'controller_name' => 'CreationController',
            'emissions' => $emission,
            'audios' => $audio,
            'inscriptions' => $inscription,
            'membres' => null,
            'participants' => null,
            'utilisateurs' => null,
            'admin' => false
        ]);
    }
}
