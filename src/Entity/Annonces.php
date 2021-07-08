<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\AnnoncesRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=AnnoncesRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 */
class Annonces
{
    use Timestampable;

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
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length(min=10)
     */
    private $description;

    /**
     * @ORM\Column(type="bigint")
     * @Assert\NotBlank
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     */
    private $surface;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     */
    private $rooms;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     */
    private $bedrooms;

    /**
     * @ORM\Column(type="boolean" , options={"default": "0"})
     */
    private $statusAnnonce;

    /**
     * @ORM\OneToMany(targetEntity=Images::class, mappedBy="annonces", orphanRemoval=true, cascade={"persist"})
     */
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(?int $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getRooms(): ?int
    {
        return $this->rooms;
    }

    public function setRooms(?int $rooms): self
    {
        $this->rooms = $rooms;

        return $this;
    }

    public function getBedrooms(): ?int
    {
        return $this->bedrooms;
    }

    public function setBedrooms(?int $bedrooms): self
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    public function getStatusAnnonce(): ?bool
    {
        return $this->statusAnnonce;
    }

    public function setStatusAnnonce(bool $statusAnnonce): self
    {
        $this->statusAnnonce = $statusAnnonce;

        return $this;
    }

    /**
     * @return Collection|Images[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setAnnonces($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getAnnonces() === $this) {
                $image->setAnnonces(null);
            }
        }

        return $this;
    }


}
