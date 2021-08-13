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
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=AnnoncesRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 */
class Annonces
{
    use Timestampable;

    const TYPE = [
        0 => 'studio',
        1 => 'Appartement T1',
        2 => 'Appartement T2',
        3 => 'Appartement T3',
        4 => 'Appartement T4 et +',
        5 => 'Duplex',
        6 => 'Maison 2 pièces',
        7 => 'Maison 3 pièces',
        8 => 'Maison 4 pièces et +',
        9 => 'Terrain',
        10 => 'Résidence Senior',
        11 => 'Résidence étudiante',
        12 => 'Résidence de tourisme',
    ];

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
     * @Assert\NotBlank
     */
    private $images;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Quartier::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="id")
     * @Assert\NotBlank
     */
    private $quartier;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $location;

    /**
     * @ORM\Column(type="boolean", options={"default":false})
     */
    private $sold;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Market::class, inversedBy="annonce", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $market;

    /**
     * @ORM\ManyToOne(targetEntity=Hopital::class, inversedBy="annonce", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $hopital;

    /**
     * @ORM\ManyToOne(targetEntity=School::class, inversedBy="annonce", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $school;

    /**
     * @ORM\ManyToOne(targetEntity=SuperMarket::class, inversedBy="annonce", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $superMarket;

    /**
     * @ORM\ManyToOne(targetEntity=Restaurant::class, inversedBy="annonce", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $restaurant;

    /**
     * @ORM\Column(type="boolean", options={"default": "0"})
     */
    private $approved;

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

    public function setStatusAnnonce(?bool $statusAnnonce): self
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

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(?int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getTypeBien(): ?string
    {
        return self::TYPE[$this->type];
    }

    public function getQuartier(): ?Quartier
    {
        return $this->quartier;
    }

    public function setQuartier(?Quartier $quartier): self
    {
        $this->quartier = $quartier;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getSold(): ?bool
    {
        return $this->sold;
    }

    public function setSold(?bool $sold): self
    {
        $this->sold = $sold;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getMarket(): ?Market
    {
        return $this->market;
    }

    public function setMarket(?Market $market): self
    {
        $this->market = $market;

        return $this;
    }

    public function getHopital(): ?Hopital
    {
        return $this->hopital;
    }

    public function setHopital(?Hopital $hopital): self
    {
        $this->hopital = $hopital;

        return $this;
    }

    public function getSchool(): ?School
    {
        return $this->school;
    }

    public function setSchool(?School $school): self
    {
        $this->school = $school;

        return $this;
    }

    public function getSuperMarket(): ?SuperMarket
    {
        return $this->superMarket;
    }

    public function setSuperMarket(?SuperMarket $superMarket): self
    {
        $this->superMarket = $superMarket;

        return $this;
    }

    public function getRestaurant(): ?Restaurant
    {
        return $this->restaurant;
    }

    public function setRestaurant(?Restaurant $restaurant): self
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    public function getApproved(): ?bool
    {
        return $this->approved;
    }

    public function setApproved(?bool $approved): self
    {
        $this->approved = $approved;

        return $this;
    }


}
