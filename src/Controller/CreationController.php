<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


use App\Entity\Emission;
use App\Entity\Audio;
use Symfony\Component\HttpFoundation\JsonResponse;

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

    #[Route('/creation/{ID}/audios', name: 'app_creation_get_audios')]
    public function getAudiosFromEmission(EntityManagerInterface $em, $ID): JsonResponse
    {
        $emission = $em->getRepository(Emission::class)->find($ID);

        if (!$emission) {
            throw $this->createNotFoundException(
                'No emission found for id ' . $ID
            );
        }

        $audios = $emission->getAudio();

        $data = array();
        foreach ($audios as $audio) {
            $data[] = array(
                'ID' => $audio->getId(),
                'NOM' => $audio->getNOM(),
                'DESCRIPTION' => $audio->getDESCRIPTION(),
                'HEURE' => $audio->getHEURE(),
                'DATE' => $audio->getDATE(),
                'AUDIO' => $audio->getAUDIO(),
                'AUTEURS' => $audio->getAUTEURS()
            );
        }

        return new JsonResponse($data);
    }
}
