<?php

namespace App\Entity;

use App\Repository\AssoAwardRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssoAwardRepository::class)]
class AssoAward
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_award = null;

    #[ORM\Column]
    private ?int $id_book = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdAward(): ?int
    {
        return $this->id_award;
    }

    public function setIdAward(int $id_award): static
    {
        $this->id_award = $id_award;

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
