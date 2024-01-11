<?php

namespace App\Entity;

use App\Repository\AssoCatRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssoCatRepository::class)]
class AssoCat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_cat = null;

    #[ORM\Column]
    private ?int $id_book = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCat(): ?int
    {
        return $this->id_cat;
    }

    public function setIdCat(int $id_cat): static
    {
        $this->id_cat = $id_cat;

        return $this;
    }

    public function getIdBook(): ?int
    {
        return $this->id_book;
    }

    public function setIdBook(int $id_book): static
    {
        $this->id_book = $id_book;

        return $this;
    }
}
