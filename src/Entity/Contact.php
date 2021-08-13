<?php
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact {
    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=50)
     */
    private $firstname;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=50)
     */
    private $lastname;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/[0-9]{8}/")
     */
    private $phone;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=10)
     */
    private $message;

    /**
     * @var Annonces|null
     */
    private $annonce;

    /**
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string|null $firstname
     * @return Contact
     */
    public function setFirstname(?string $firstname): Contact
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return Contact
     */
    public function setLastname(?string $lastname): Contact
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return Contact
     */
    public function setPhone(?string $phone): Contact
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Contact
     */
    public function setEmail(?string $email): Contact
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Contact
     */
    public function setMessage(?string $message): Contact
    {
        $this->message = $message;

        return $this;
    }

    /**
     *
     * @return Annonces|null
     */
    public function getAnnonce(): ?Annonces
    {
        return $this->annonce;
    }

    /**
     *
     * @param Annonces|null $annonce
     * @return Contact
     */
    public function setAnnonce(?Annonces $annonce): Contact
    {
        $this->annonce = $annonce;

        return $this;
    }

}