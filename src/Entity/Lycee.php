<?php

namespace App\Entity;

use App\Repository\LyceeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LyceeRepository::class)]
class Lycee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $NOM = null;

    #[ORM\Column(length: 255)]
    private ?string $DESCRIPTION = null;

    #[ORM\Column(length: 255)]
    private ?string $MAIL = null;

    #[ORM\Column(length: 255)]
    private ?string $CODEP = null;

    #[ORM\Column(length: 255)]
    private ?string $VILLE = null;

    #[ORM\Column(length: 255)]
    private ?string $TELEPHONE = null;

    #[ORM\Column(length: 255)]
    private ?string $DEPARTEMENT = null;

    #[ORM\Column(length: 255)]
    private ?string $VOIE = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMAIL(): ?string
    {
        return $this->MAIL;
    }

    public function setMAIL(string $MAIL): static
    {
        $this->MAIL = $MAIL;

        return $this;
    }

    public function getCODEP(): ?string
    {
        return $this->CODEP;
    }

    public function setCODEP(string $CODEP): static
    {
        $this->CODEP = $CODEP;

        return $this;
    }

    public function getVILLE(): ?string
    {
        return $this->VILLE;
    }

    public function setVILLE(string $VILLE): static
    {
        $this->VILLE = $VILLE;

        return $this;
    }

    public function getTELEPHONE(): ?string
    {
        return $this->TELEPHONE;
    }

    public function setTELEPHONE(string $TELEPHONE): static
    {
        $this->TELEPHONE = $TELEPHONE;

        return $this;
    }

    public function getDEPARTEMENT(): ?string
    {
        return $this->DEPARTEMENT;
    }

    public function setDEPARTEMENT(string $DEPARTEMENT): static
    {
        $this->DEPARTEMENT = $DEPARTEMENT;

        return $this;
    }

    public function getVOIE(): ?string
    {
        return $this->VOIE;
    }

    public function setVOIE(string $VOIE): static
    {
        $this->VOIE = $VOIE;

        return $this;
    }
}
