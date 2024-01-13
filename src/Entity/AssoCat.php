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

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $id_cat = null;

    #[ORM\OneToMany(mappedBy: 'id_cat', targetEntity: Book::class)]
    private Collection $id_book;

    public function __construct()
    {
        $this->id_book = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCat(): ?Category
    {
        return $this->id_cat;
    }

    public function setIdCat(Category $id_cat): static
    {
        $this->id_cat = $id_cat;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getIdBook(): Collection
    {
        return $this->id_book;
    }

    public function addIdBook(Book $idBook): static
    {
        if (!$this->id_book->contains($idBook)) {
            $this->id_book->add($idBook);
            $idBook->setIdCat($this);
        }

        return $this;
    }

    public function removeIdBook(Book $idBook): static
    {
        if ($this->id_book->removeElement($idBook)) {
            // set the owning side to null (unless already changed)
            if ($idBook->getIdCat() === $this) {
                $idBook->setIdCat(null);
            }
        }

        return $this;
    }


}
