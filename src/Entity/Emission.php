<?php

namespace App\Entity;

use App\Repository\EmissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmissionRepository::class)]
class Emission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $ID = null;

    #[ORM\Column(length: 255)]
    private ?string $NOM = null;

    #[ORM\Column(length: 255)]
    private ?string $NOMLONG = null;

    #[ORM\Column(length: 255)]
    private ?string $DESCRIPTION = null;

    #[ORM\Column(length: 255)]
    private ?string $IMG = null;

    #[ORM\Column]
    private ?bool $INSCRIPTION = null;

    #[ORM\OneToMany(mappedBy: 'IDEMISSION', targetEntity: Audio::class, orphanRemoval: true)]
    private Collection $audio;

    /*
    #[ORM\OneToMany(mappedBy: 'IDEMISSION', targetEntity: Inscription::class)]
    private Collection $inscriptions;*/

    public function __construct()
    {
        $this->audio = new ArrayCollection();
        //$this->inscriptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->ID;
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

    public function getNOMLONG(): ?string
    {
        return $this->NOMLONG;
    }

    public function setNOMLONG(string $NOMLONG): static
    {
        $this->NOMLONG = $NOMLONG;

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

    public function getIMG(): ?string
    {
        return $this->IMG;
    }

    public function setIMG(string $IMG): static
    {
        $this->IMG = $IMG;

        return $this;
    }

    public function isINSCRIPTION(): ?bool
    {
        return $this->INSCRIPTION;
    }

    public function setINSCRIPTION(bool $INSCRIPTION): static
    {
        $this->INSCRIPTION = $INSCRIPTION;

        return $this;
    }

    /**
     * @return Collection<int, Audio>
     */
    public function getAudio(): Collection
    {
        return $this->audio;
    }

    public function addAudio(Audio $audio): static
    {
        if (!$this->audio->contains($audio)) {
            $this->audio->add($audio);
            $audio->setIDEMISSION($this);
        }

        return $this;
    }

    public function removeAudio(Audio $audio): static
    {
        if ($this->audio->removeElement($audio)) {
            // set the owning side to null (unless already changed)
            if ($audio->getIDEMISSION() === $this) {
                $audio->setIDEMISSION(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->NOM;
    }
}
