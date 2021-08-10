<?php

namespace App\Entity;

use App\Repository\HopitalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=HopitalRepository::class)
 * @ORM\Table(name="hopitaux")
 */
class Hopital
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
    private $titleH;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $adresseH;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $descriptionH;

    /**
     * @ORM\OneToMany(targetEntity=Annonces::class, mappedBy="hopital", orphanRemoval=true)
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

    public function getTitleH(): ?string
    {
        return $this->titleH;
    }

    public function setTitleH(string $titleH): self
    {
        $this->titleH = $titleH;

        return $this;
    }

    public function getAdresseH(): ?string
    {
        return $this->adresseH;
    }

    public function setAdresseH(string $adresseH): self
    {
        $this->adresseH = $adresseH;

        return $this;
    }

    public function getDescriptionH(): ?string
    {
        return $this->descriptionH;
    }

    public function setDescriptionH(?string $descriptionH): self
    {
        $this->descriptionH = $descriptionH;

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
            $annonce->setHopital($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonces $annonce): self
    {
        if ($this->annonce->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getHopital() === $this) {
                $annonce->setHopital(null);
            }
        }

        return $this;
    }
}
