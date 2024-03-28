<?php 

namespace App\EventListener;

use App\Entity\Emission;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

class LecteurListener 
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $controller = $event->getController();
        
        if (is_array($controller)) {
            $controller = $controller[0];
        }

        
        if ($controller instanceof \Symfony\Bundle\FrameworkBundle\Controller\AbstractController) {
            
            $emission = $this->em->getRepository(Emission::class);

            $lesEmissions = $emission->findAll();

            $data = [];
            
            foreach ($lesEmissions as $emission) {
                $lesAudios = $emission->getAudio();
                $data[$emission->getNom()] = $lesAudios;
            }

            $event->getRequest()->attributes->set('lecteurdata', $data);
        }
    }
}