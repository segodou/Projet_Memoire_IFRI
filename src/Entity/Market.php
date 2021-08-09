<?php

namespace App\Entity;

use App\Repository\MarketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MarketRepository::class)
 * @ORM\Table(name="markets")
 */
class Market
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
    private $titleM;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $adresseM;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $descriptionM;

    /**
     * @ORM\OneToMany(targetEntity=Annonces::class, mappedBy="market", orphanRemoval=true)
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

    public function getTitleM(): ?string
    {
        return $this->titleM;
    }

    public function setTitleM(string $titleM): self
    {
        $this->titleM = $titleM;

        return $this;
    }

    public function getAdresseM(): ?string
    {
        return $this->adresseM;
    }

    public function setAdresseM(string $adresseM): self
    {
        $this->adresseM = $adresseM;

        return $this;
    }

    public function getDescriptionM(): ?string
    {
        return $this->descriptionM;
    }

    public function setDescriptionM(string $descriptionM): self
    {
        $this->descriptionM = $descriptionM;

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
            $annonce->setMarket($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonces $annonce): self
    {
        if ($this->annonce->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getMarket() === $this) {
                $annonce->setMarket(null);
            }
        }

        return $this;
    }
}
