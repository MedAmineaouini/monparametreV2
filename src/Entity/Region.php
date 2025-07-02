<?php

namespace App\Entity;

use App\Repository\RegionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Departement;

#[ORM\Entity(repositoryClass: RegionRepository::class)]
#[ORM\Table(name: 'REGION')]
class Region
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: 'SEQREGION', type: 'integer')]
    private ?int $seqregion = null;

    #[ORM\Column(name: 'LIBREGION', type: 'string', length: 50)]
    private string $libregion = '';

    #[ORM\OneToMany(
        mappedBy: 'region', 
        targetEntity: Departement::class,
        cascade: ['persist', 'remove']
    )]
    private Collection $departements;

    public function __construct()
    {
        $this->departements = new ArrayCollection();
    }

    public function getSeqregion(): ?int
    {
        return $this->seqregion;
    }

    public function getLibregion(): string
    {
        return $this->libregion;
    }

    public function setLibregion(string $libregion): static
    {
        $this->libregion = $libregion;
        return $this;
    }

    /**
     * @return Collection<int, Departement>
     */
    public function getDepartements(): Collection
    {
        return $this->departements;
    }

    public function addDepartement(Departement $departement): static
    {
        if (!$this->departements->contains($departement)) {
            $this->departements->add($departement);
            $departement->setRegion($this);
        }

        return $this;
    }

    public function removeDepartement(Departement $departement): static
    {
        if ($this->departements->removeElement($departement)) {
            if ($departement->getRegion() === $this) {
                $departement->setRegion(null);
            }
        }

        return $this;
    }
    
    public function __toString(): string
    {
        return $this->libregion;
    }
}
