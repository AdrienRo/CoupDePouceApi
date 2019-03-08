<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OfferRepository")
 */
class Offer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Amount", mappedBy="offer", orphanRemoval=true)
     */
    private $amounts;

    public function __construct()
    {
        $this->amounts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Amount[]
     */
    public function getAmounts(): Collection
    {
        return $this->amounts;
    }

    public function addAmount(Amount $amount): self
    {
        if (!$this->amounts->contains($amount)) {
            $this->amounts[] = $amount;
            $amount->setOffer($this);
        }

        return $this;
    }

    public function removeAmount(Amount $amount): self
    {
        if ($this->amounts->contains($amount)) {
            $this->amounts->removeElement($amount);
            // set the owning side to null (unless already changed)
            if ($amount->getOffer() === $this) {
                $amount->setOffer(null);
            }
        }

        return $this;
    }
}
