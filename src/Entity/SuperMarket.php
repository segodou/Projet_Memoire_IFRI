<?php

namespace App\Entity;

use App\Repository\SuperMarketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SuperMarketRepository::class)
 * @ORM\Table(name="superMarkets")
 */
class SuperMarket
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min=5)
     */
    private $titleSM;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $adresseSM;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $descriptionSM;

    /**
     * @ORM\OneToMany(targetEntity=Annonces::class, mappedBy="superMarket", orphanRemoval=true)
     */
    private $annonce;

    public function __construct()
    {
        $this->annonce = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleSM(): ?string
    {
        return $this->titleSM;
    }

    public function setTitleSM(string $titleSM): self
    {
        $this->titleSM = $titleSM;

        return $this;
    }

    public function getAdresseSM(): ?string
    {
        return $this->adresseSM;
    }

    public function setAdresseSM(string $adresseSM): self
    {
        $this->adresseSM = $adresseSM;

        return $this;
    }

    public function getDescriptionSM(): ?string
    {
        return $this->descriptionSM;
    }

    public function setDescriptionSM(?string $descriptionSM): self
    {
        $this->descriptionSM = $descriptionSM;

        return $this;
    }

    /**
     * @return Collection|Annonces[]
     */
    public function getAnnonce(): Collection
    {
        return $this->annonce;
    }

    public function addAnnonce(Annonces $annonce): self
    {
        if (!$this->annonce->contains($annonce)) {
            $this->annonce[] = $annonce;
            $annonce->setSuperMarket($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonces $annonce): self
    {
        if ($this->annonce->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getSuperMarket() === $this) {
                $annonce->setSuperMarket(null);
            }
        }

        return $this;
    }
}
