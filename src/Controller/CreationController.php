<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


use App\Entity\Emission;
use App\Entity\Audio;
use App\Entity\Equipe;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreationController extends AbstractController
{
    #[Route('/admin/creation', name: 'app_creation')]
    public function index(EntityManagerInterface $em): Response
    {


        $emission = $em->getRepository(Emission::class)->findAll();
        $audio = $em->getRepository(Audio::class)->findAll();
        $membres = $em->getRepository(Equipe::class)->findAll();

        return $this->render('creation/index.html.twig', [
            'controller_name' => 'CreationController',
            'emissions' => $emission,
            'audios' => $audio,
            'membres' => $membres
        ]);
    }

    #[Route('/admin/creation/{ID}/audios', name: 'app_creation_get_audios')]
    public function getAudiosFromEmission(EntityManagerInterface $em, $ID): JsonResponse
    {
        $emission = $em->getRepository(Emission::class)->find($ID);

        if (!$emission) {
            return new JsonResponse(array('message' => 'Emission not found'), Response::HTTP_NOT_FOUND);
        }

        $audios = $emission->getAudio();

        $data = array();
        foreach ($audios as $audio) {
            $data[] = array(
                'ID' => $audio->getId(),
                'NOM' => $audio->getNOM(),
                'DESCRIPTION' => $audio->getDESCRIPTION(),
                'HEURE' => $audio->getHEURE()->format('H:i:s'),
                'DATE' => $audio->getDATE()->format('Y-m-d'),
                'AUDIO' => $audio->getAUDIO(),
                'AUTEURS' => $audio->getAUTEURS()
            );
        }

        return new JsonResponse($data);
    }
}
