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
    private ?Awarded $id_awarded = null;

    #[ORM\OneToMany(mappedBy: 'id_award', targetEntity: book::class)]
    private Collection $id_book;

    public function __construct()
    {
        $this->id_book = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdAwarded(): ?Awarded
    {
        return $this->id_awarded;
    }

    public function setIdAwarded(Awarded $id_awarded): static
    {
        $this->id_awarded = $id_awarded;

        return $this;
    }

    /**
     * @return Collection<int, book>
     */
    public function getIdBook(): Collection
    {
        return $this->id_book;
    }

    public function addIdBook(book $idBook): static
    {
        if (!$this->id_book->contains($idBook)) {
            $this->id_book->add($idBook);
            $idBook->setIdAward($this);
        }

        return $this;
    }

    public function removeIdBook(book $idBook): static
    {
        if ($this->id_book->removeElement($idBook)) {
            // set the owning side to null (unless already changed)
            if ($idBook->getIdAward() === $this) {
                $idBook->setIdAward(null);
            }
        }

        return $this;
    }

}
