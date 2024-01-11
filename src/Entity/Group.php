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

    #[ORM\Column(length: 255)]
    private ?string $name_group = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $CreationDate = null;

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

    public function getName_group()
    {
        return $this->name_group;
    }

    public function setName_group($name_group)
    {
        $this->name_group = $name_group;

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

}
