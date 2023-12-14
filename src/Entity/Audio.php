<?php

namespace App\Entity;

use App\Repository\AudioRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AudioRepository::class)]
class Audio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'audio')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Emission $IDEMISSION = null;

    #[ORM\Column(length: 255)]
    private ?string $NOM = null;

    #[ORM\Column(length: 255)]
    private ?string $DESCRIPTION = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $HEURE = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DATE = null;

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

    public function getDESCRIPTION(): ?string
    {
        return $this->DESCRIPTION;
    }

    public function setDESCRIPTION(string $DESCRIPTION): static
    {
        $this->DESCRIPTION = $DESCRIPTION;

        return $this;
    }

    public function getHEURE(): ?\DateTimeInterface
    {
        return $this->HEURE;
    }

    public function setHEURE(\DateTimeInterface $HEURE): static
    {
        $this->HEURE = $HEURE;

        return $this;
    }

    public function getDATE(): ?\DateTimeInterface
    {
        return $this->DATE;
    }

    public function setDATE(\DateTimeInterface $DATE): static
    {
        $this->DATE = $DATE;

        return $this;
    }
}
