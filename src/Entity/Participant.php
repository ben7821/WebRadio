<?php

namespace App\Entity;

use App\Repository\ParticipantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParticipantRepository::class)]
class Participant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $PRENOM = null;

    #[ORM\Column(length: 255)]
    private ?string $NOM = null;

    #[ORM\Column(length: 255)]
    private ?string $TEL = null;

    #[ORM\Column(length: 255)]
    private ?string $MAIL = null;

    #[ORM\ManyToOne(inversedBy: 'PARTICIPANT')]
    private ?Inscription $inscription = null;


    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPRENOM(): ?string
    {
        return $this->PRENOM;
    }

    public function setPRENOM(string $PRENOM): static
    {
        $this->PRENOM = $PRENOM;

        return $this;
    }

    public function getNOM(): ?string
    {
        return $this->NOM;
    }

    public function setNOM(string $NOM): static
    {
        $this->NOM = $NOM;

        return $this;
    }

    public function getTEL(): ?string
    {
        return $this->TEL;
    }

    public function setTEL(string $TEL): static
    {
        $this->TEL = $TEL;

        return $this;
    }

    public function getMAIL(): ?string
    {
        return $this->MAIL;
    }

    public function setMAIL(string $MAIL): static
    {
        $this->MAIL = $MAIL;

        return $this;
    }

    public function toString() {
        return (string) $this->inscription;
    }

    public function getInscription(): ?Inscription
    {
        return $this->inscription;
    }

    public function setInscription(?Inscription $inscription): static
    {
        $this->inscription = $inscription;

        return $this;
    }
    
}
