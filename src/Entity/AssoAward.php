<?php

namespace App\Entity;

use App\Repository\AssoAwardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssoAwardRepository::class)]
class AssoAward
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Awarded $id_award = null;

    #[ORM\OneToOne(inversedBy: 'id_award', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?Book $id_book = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdAward(): ?Awarded
    {
        return $this->id_award;
    }

    public function setIdAward(Awarded $id_award): static
    {
        $this->id_award = $id_award;

        return $this;
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


}
