<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupRepository::class)]
#[ORM\Table(name: '`group`')]
class Group
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $IdBook = null;

    #[ORM\Column]
    private ?int $IdUser = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $CreationDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $ReunionDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdBook(): ?int
    {
        return $this->IdBook;
    }

    public function setIdBook(int $IdBook): static
    {
        $this->IdBook = $IdBook;

        return $this;
    }

    public function getIdUser(): ?int
    {
        return $this->IdUser;
    }

    public function setIdUser(int $IdUser): static
    {
        $this->IdUser = $IdUser;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->CreationDate;
    }

    public function setCreationDate(\DateTimeInterface $CreationDate): static
    {
        $this->CreationDate = $CreationDate;

        return $this;
    }

    public function getReunionDate(): ?\DateTimeInterface
    {
        return $this->ReunionDate;
    }

    public function setReunionDate(\DateTimeInterface $ReunionDate): static
    {
        $this->ReunionDate = $ReunionDate;

        return $this;
    }
}
