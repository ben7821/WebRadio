<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    private ?Journal $IDJOURNAL = null;

    #[ORM\Column(length: 255)]
    private ?string $NOM = null;

    #[ORM\Column(length: 255)]
    private ?string $AUTEUR = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DATE = null;

    #[ORM\Column(length: 255)]
    private ?string $DESCRIPTION = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIDJOURNAL(): ?Journal
    {
        return $this->IDJOURNAL;
    }

    public function setIDJOURNAL(?Journal $IDJOURNAL): static
    {
        $this->IDJOURNAL = $IDJOURNAL;

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

    public function getAUTEUR(): ?string
    {
        return $this->AUTEUR;
    }

    public function setAUTEUR(string $AUTEUR): static
    {
        $this->AUTEUR = $AUTEUR;

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

    public function getDESCRIPTION(): ?string
    {
        return $this->DESCRIPTION;
    }

    public function setDESCRIPTION(string $DESCRIPTION): static
    {
        $this->DESCRIPTION = $DESCRIPTION;

        return $this;
    }
}
