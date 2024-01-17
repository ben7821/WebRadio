<?php 

namespace App\EventSubscriber;

use App\Entity\Emission;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EmissionSubscriber implements EventSubscriberInterface
{
    private $audioPath;

    public function __construct($audioPath) {
        $this->audioPath = $audioPath;
    }

    public static function getSubscribedEvents() {
        return [
            Events::postPersist
        ];
    }

    public function postPersist(LifecycleEventArgs $args) {
        $entity = $args->getObject();

        if ($entity instanceof Emission) {
            $audio = $this->audioPath . '/' . $entity->getNOM();

            $fs = new Filesystem();
            $fs->mkdir($audio, 0775);
        }
    }
}
