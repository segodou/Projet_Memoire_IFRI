<?php

namespace App\Entity;

use App\Repository\CommuneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommuneRepository::class)
 */
class Commune
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Departement::class, inversedBy="communes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $departement;

    /**
     * @ORM\OneToMany(targetEntity=Arrondissement::class, mappedBy="commune", orphanRemoval=true)
     */
    private $arrondissements;


    public function __construct()
    {
        $this->arrondissements = new ArrayCollection();
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

    public function getDepartement(): ?Departement
    {
        return $this->departement;
    }

    public function setDepartement(?Departement $departement): self
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * @return Collection|Arrondissement[]
     */
    public function getArrondissements(): Collection
    {
        return $this->arrondissements;
    }

    public function addArrondissement(Arrondissement $arrondissement): self
    {
        if (!$this->arrondissements->contains($arrondissement)) {
            $this->arrondissements[] = $arrondissement;
            $arrondissement->setCommune($this);
        }

        return $this;
    }

    public function removeArrondissement(Arrondissement $arrondissement): self
    {
        if ($this->arrondissements->removeElement($arrondissement)) {
            // set the owning side to null (unless already changed)
            if ($arrondissement->getCommune() === $this) {
                $arrondissement->setCommune(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
