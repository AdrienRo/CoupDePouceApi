<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AmountRepository")
 */
class Amount
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $unit;

    /**
     * @ORM\Column(type="smallint")
     */
    private $value;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ressource_cat;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Offer", inversedBy="amounts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $offer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getRessourceCat(): ?string
    {
        return $this->ressource_cat;
    }

    public function setRessourceCat(string $ressource_cat): self
    {
        $this->ressource_cat = $ressource_cat;

        return $this;
    }

    public function getOffer(): ?Offer
    {
        return $this->offer;
    }

    public function setOffer(?Offer $offer): self
    {
        $this->offer = $offer;

        return $this;
    }
}
