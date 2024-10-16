<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Collection;


#[ORM\Entity(repositoryClass: GroupRepository::class)]
#[ORM\Table(name: '`group`')]
class Group
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    public ?string $name_group = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $CreationDate = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Book $id_book = null;

    #[ORM\OneToMany(targetEntity: InGroup::class, mappedBy: 'group')]
    private $inGroups;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIdBook(): ?Book
    {
        return $this->id_book;
    }

    public function setIdBook(Book $id_book): static
    {
        $this->id_book = $id_book;

        return $this;
    }
/*
    public function setInGroups(Collection $inGroups): self
    {
        $this->inGroups = $inGroups;

        return $this;
    }

    public function getInGroups(): Collection
    {
        return $this->inGroups;
    }

    public function getUser(): Collection
    {
        return $this->inGroups->map(fn (InGroup $inGroup) => $inGroup->getUser());
    }

    public function setUser(Collection $users): self
    {
        foreach ($users as $user) {
            $inGroup = new InGroup();
            $inGroup->setUser($user);
            $inGroup->setGroup($this);
            $this->inGroups->add($inGroup);
        }

        return $this;
    }
 */   

    public function getInGroups()
    {
        return $this->inGroups;
    }

    public function setInGroups($inGroups)
    {
        $this->inGroups = $inGroups;

        return $this;
    }
}
