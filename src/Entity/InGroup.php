<?php

namespace App\Entity;

use App\Repository\InGroupRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InGroupRepository::class)]
class InGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Group $id_group = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $id_user = null;


    public function getId(): ?int
    {
        return $this->id;
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

    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(?User $id_user): static
    {
        $this->id_user = $id_user;

        return $this;
    }

}
