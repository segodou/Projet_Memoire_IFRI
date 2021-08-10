<?php

namespace App\Entity;

use App\Repository\RestaurantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RestaurantRepository::class)
 * @ORM\Table(name="restaurants")
 */
class Restaurant
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
    private $titleR;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $adresseR;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $descriptionR;

    /**
     * @ORM\OneToMany(targetEntity=Annonces::class, mappedBy="restaurant", orphanRemoval=true)
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

    public function getTitleR(): ?string
    {
        return $this->titleR;
    }

    public function setTitleR(string $titleR): self
    {
        $this->titleR = $titleR;

        return $this;
    }

    public function getAdresseR(): ?string
    {
        return $this->adresseR;
    }

    public function setAdresseR(string $adresseR): self
    {
        $this->adresseR = $adresseR;

        return $this;
    }

    public function getDescriptionR(): ?string
    {
        return $this->descriptionR;
    }

    public function setDescriptionR(?string $descriptionR): self
    {
        $this->descriptionR = $descriptionR;

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
            $annonce->setRestaurant($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonces $annonce): self
    {
        if ($this->annonce->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getRestaurant() === $this) {
                $annonce->setRestaurant(null);
            }
        }

        return $this;
    }
}
