<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name_cat = null;

    #[ORM\Column]
    private ?int $id_book = null;    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name_cat;
    }

    public function setName($name_cat)
    {
        $this->name_cat = $name_cat;

        return $this;
    }

    public function getIdBook()
    {
        return $this->id_book;
    }

    public function setIdBook($id_book)
    {
        $this->idBook = $id_book;

        return $this;
    }
}
