<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Article;
use App\Entity\Emission;

use App\Controller\LayoutController;

class HomeController extends LayoutController
{
    #[Route('/home', name: 'app_home')]
    public function index(EntityManagerInterface $em): Response
    {
        $article = $em->getRepository(Article::class)->findAll();
        $emission = $em->getRepository(Emission::class)->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'article' => $article,
            'emissions' => $emission,
        ]);
    }
}
