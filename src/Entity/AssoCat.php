<?php

namespace App\Entity;

use App\Repository\AssoCatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssoCatRepository::class)]
class AssoCat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'id_category', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?Book $id_book = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $id_category = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdBook(): ?Book
    {
        return $this->id_book;
    }

    public function setIdBook(Book $id_book): static
    {
        $this->id_book = $id_book;

        return $this;
    }

    public function getIdCategory(): ?Category
    {
        return $this->id_category;
    }

    public function setIdCategory(Category $id_category): static
    {
        $this->id_category = $id_category;

        return $this;
    }


}
