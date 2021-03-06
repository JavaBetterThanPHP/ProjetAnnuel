<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserDiplomaRepository")
 */
class UserDiploma
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Diploma", inversedBy="userDiplomas")
     */
    private $diploma;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userDiplomas")
     */
    private $user;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateOfGrant;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $mention;

    public function getId()
    {
        return $this->id;
    }

    public function getDiploma(): ?Diploma
    {
        return $this->diploma;
    }

    public function setDiploma(?Diploma $diploma): self
    {
        $this->diploma = $diploma;

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

    public function getDateOfGrant(): ?\DateTimeInterface
    {
        return $this->dateOfGrant;
    }

    public function setDateOfGrant(?\DateTimeInterface $dateOfGrant): self
    {
        $this->dateOfGrant = $dateOfGrant;

        return $this;
    }

    public function getMention(): ?string
    {
        return $this->mention;
    }

    public function setMention(string $mention): self
    {
        $this->mention = $mention;

        return $this;
    }
}
