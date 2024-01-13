<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $author = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\ManyToOne(inversedBy: 'id_book')]
    private ?AssoAward $id_award = null;

    #[ORM\ManyToOne(inversedBy: 'id_book')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AssoCat $id_cat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getIdAward(): ?AssoAward
    {
        return $this->id_award;
    }

    public function setIdAward(?AssoAward $id_award): static
    {
        $this->id_award = $id_award;

        return $this;
    }

    public function getIdCat(): ?AssoCat
    {
        return $this->id_cat;
    }

    public function setIdCat(?AssoCat $id_cat): static
    {
        $this->id_cat = $id_cat;

        return $this;
    }
}
