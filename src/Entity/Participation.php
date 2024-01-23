<?php

namespace App\Entity;

use App\Repository\ParticipationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParticipationRepository::class)]
class Participation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    
    #[ORM\ManyToOne(targetEntity: Participant::class, inversedBy: 'participation')]
    protected $PARTICIPANT;

    #[ORM\ManyToOne(targetEntity: Inscription::class)]
    protected $INSCRIPTION;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function toString(){
        return $this->id.$this->PARTICIPANT.$this->INSCRIPTION;
    }
}