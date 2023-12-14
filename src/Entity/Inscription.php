<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Emission $IDEMISSION = null;

    #[ORM\Column(length: 255)]
    private ?string $NOM = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIDEMISSION(): ?Emission
    {
        return $this->IDEMISSION;
    }

    public function setIDEMISSION(?Emission $IDEMISSION): static
    {
        $this->IDEMISSION = $IDEMISSION;

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
}
