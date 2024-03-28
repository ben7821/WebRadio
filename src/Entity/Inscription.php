<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DATE = null;

    #[ORM\ManyToOne(inversedBy: 'emission')]
    private ?Emission $EMS = null;

    #[ORM\OneToMany(mappedBy: 'inscription', targetEntity: Participant::class)]
    private $PARTICIPANT;

    #[ORM\Column]
    private ?bool $valid = null;

    public function __construct()
    {
        $this->PARTICIPANT = new ArrayCollection();
    }

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

    public function getEMS(): ?Emission
    {
        return $this->EMS;
    }

    public function setEMS(?Emission $EMS): static
    {
        $this->EMS = $EMS;

        return $this;
    }

    public function toString(){
        return $this->id;
    }

    /**
     * @return Collection<int, Participant>
     */
    public function getPARTICIPANT(): Collection
    {
        return $this->PARTICIPANT;
    }

    public function addPARTICIPANT(Participant $pARTICIPANT): static
    {
        if (!$this->PARTICIPANT->contains($pARTICIPANT)) {
            $this->PARTICIPANT->add($pARTICIPANT);
            $pARTICIPANT->setInscription($this);
        }

        return $this;
    }

    public function removePARTICIPANT(Participant $pARTICIPANT): static
    {
        if ($this->PARTICIPANT->removeElement($pARTICIPANT)) {
            // set the owning side to null (unless already changed)
            if ($pARTICIPANT->getInscription() === $this) {
                $pARTICIPANT->setInscription(null);
            }
        }

        return $this;
    }

    public function isValid(): ?bool
    {
        return $this->valid;
    }

    public function setValid(bool $valid): static
    {
        $this->valid = $valid;

        return $this;
    }
}
