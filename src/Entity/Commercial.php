<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "COMMERCIAL")]
#[UniqueEntity('codeCommercial', message: 'Cet commercial est  existe déjà')]
class Commercial
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "SEQCOMMERCIAL", type: "integer")]
    private ?int $seqCommercial = null;  // Changé en nullable

    #[ORM\Column(name: "CODECOMMERCIAL", type: "string", length: 4, unique: true)]  // Ajout unique
    private string $codeCommercial = '';

    #[ORM\Column(name: "NOMCOMMERCIAL", type: "string", length: 30)]
    private string $nomCommercial = '';

    #[ORM\Column(name: "PRENOMCOMMERCIAL", type: "string", length: 25)]
    private string $prenomCommercial = '';

    #[ORM\Column(name: "TELCOMMERCIAL", type: "string", length: 20)]
    private string $telCommercial = '';

    #[ORM\OneToMany(
        mappedBy: 'commercial', 
        targetEntity: Departement::class,
        orphanRemoval: true  // Ajout pour la suppression automatique
    )]
    private Collection $departements;

    public function __construct()
    {
        $this->departements = new ArrayCollection();
    }

    public function getSeqCommercial(): ?int
    {
        return $this->seqCommercial;
    }

    public function getCodeCommercial(): string
    {
        return $this->codeCommercial;
    }

    public function setCodeCommercial(string $code): self
    {
        $this->codeCommercial = $code;
        return $this;
    }

    public function getNomCommercial(): string
    {
        return $this->nomCommercial;
    }

    public function setNomCommercial(string $nom): self
    {
        $this->nomCommercial = $nom;
        return $this;
    }

    public function getPrenomCommercial(): string
    {
        return $this->prenomCommercial;
    }

    public function setPrenomCommercial(string $prenom): self
    {
        $this->prenomCommercial = $prenom;
        return $this;
    }

    public function getTelCommercial(): string
    {
        return $this->telCommercial;
    }

    public function setTelCommercial(string $tel): self
    {
        $this->telCommercial = $tel;
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
            $departement->setCommercial($this);
        }

        return $this;
    }

    public function removeDepartement(Departement $departement): static
    {
        if ($this->departements->removeElement($departement)) {
            if ($departement->getCommercial() === $this) {
                $departement->setCommercial(null);
            }
        }

        return $this;
    }
    
    public function __toString(): string
    {
        return $this->codeCommercial . ' - ' . $this->nomCommercial;
    }
}