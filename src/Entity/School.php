<?php

namespace App\Entity;

use App\Repository\SchoolRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=SchoolRepository::class)
 * @ORM\Table(name="schools")
 */
class School
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
    private $titleS;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $adresseS;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $descriptionS;

    /**
     * @ORM\OneToMany(targetEntity=Annonces::class, mappedBy="school", orphanRemoval=true)
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

    public function getTitleS(): ?string
    {
        return $this->titleS;
    }

    public function setTitleS(string $titleS): self
    {
        $this->titleS = $titleS;

        return $this;
    }

    public function getAdresseS(): ?string
    {
        return $this->adresseS;
    }

    public function setAdresseS(string $adresseS): self
    {
        $this->adresseS = $adresseS;

        return $this;
    }

    public function getDescriptionS(): ?string
    {
        return $this->descriptionS;
    }

    public function setDescriptionS(?string $descriptionS): self
    {
        $this->descriptionS = $descriptionS;

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
            $annonce->setSchool($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonces $annonce): self
    {
        if ($this->annonce->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getSchool() === $this) {
                $annonce->setSchool(null);
            }
        }

        return $this;
    }
}
