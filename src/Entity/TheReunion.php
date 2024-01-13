<?php

namespace App\Entity;

use App\Repository\TheReunionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TheReunionRepository::class)]
class TheReunion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_reunion = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Group $id_group = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?ThePlace $id_place = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateReunion(): ?\DateTimeInterface
    {
        return $this->date_reunion;
    }

    public function setDateReunion(\DateTimeInterface $date_reunion): static
    {
        $this->date_reunion = $date_reunion;

        return $this;
    }

    public function getIdGroup(): ?Group
    {
        return $this->id_group;
    }

    public function setIdGroup(Group $id_group): static
    {
        $this->id_group = $id_group;

        return $this;
    }

    public function getIdPlace(): ?ThePlace
    {
        return $this->id_place;
    }

    public function setIdPlace(ThePlace $id_place): static
    {
        $this->id_place = $id_place;

        return $this;
    }

}
