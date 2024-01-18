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
    private Collection $PARTICIPANT_ID;

    public function __construct()
    {
        $this->PARTICIPANT_ID = new ArrayCollection();
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

    /**
     * @return Collection<int, Participant>
     */
    public function getPARTICIPANTID(): Collection
    {
        return $this->PARTICIPANT_ID;
    }

    public function addPARTICIPANTID(Participant $pARTICIPANTID): static
    {
        if (!$this->PARTICIPANT_ID->contains($pARTICIPANTID)) {
            $this->PARTICIPANT_ID->add($pARTICIPANTID);
            $pARTICIPANTID->setInscription($this);
        }

        return $this;
    }

    public function removePARTICIPANTID(Participant $pARTICIPANTID): static
    {
        if ($this->PARTICIPANT_ID->removeElement($pARTICIPANTID)) {
            // set the owning side to null (unless already changed)
            if ($pARTICIPANTID->getInscription() === $this) {
                $pARTICIPANTID->setInscription(null);
            }
        }

        return $this;
    }
}
