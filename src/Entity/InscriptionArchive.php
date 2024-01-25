<?php

namespace App\Entity;

use App\Repository\InscriptionArchiveRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionArchiveRepository::class)]
class InscriptionArchive
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DATE = null;

    #[ORM\Column(length: 255)]
    private ?string $emission_nom = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEmissionNom(): ?string
    {
        return $this->emission_nom;
    }

    public function setEmissionNom(string $emission_nom): static
    {
        $this->emission_nom = $emission_nom;

        return $this;
    }
}
