<?php

namespace App\Entity;

use App\Repository\ThePlaceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThePlaceRepository::class)]
class ThePlace
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name_place = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNamePlace(): ?string
    {
        return $this->name_place;
    }

    public function setNamePlace(string $name_place): static
    {
        $this->name_place = $name_place;

        return $this;
    }
}
