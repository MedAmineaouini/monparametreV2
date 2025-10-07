<?php

namespace App\Entity;

use App\Repository\PaysRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: PaysRepository::class)]
#[ORM\Table(name: 'PAYS')]
class Pays
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'IDPAYS', type: 'integer')]
    private ?int $IDPAYS = null;

    #[ORM\Column(name: 'CODEPAYS', type: 'string', length: 2)]
    private ?string $CODEPAYS = null;

    #[ORM\Column(name: 'LIBPAYS', type: 'string', length: 30)]
    private ?string $LIBPAYS = null;

    #[ORM\Column(name: 'PLACE', type: 'string', length: 8)]
    private ?string $PLACE = null;

    #[ORM\Column(name: 'ORDRE', type: 'decimal', precision: 2, scale: 0)]
    private ?string $ORDRE = null;

    #[ORM\Column(name: 'NATURE', type: 'decimal', precision: 1, scale: 0)]
    private ?string $NATURE = null;

    #[ORM\Column(name: 'CONTINENT', type: 'string', length: 10)]
    private ?string $CONTINENT = null;

    #[ORM\Column(name: 'FORMALITE', type: 'text', nullable: true)]
    private ?string $FORMALITE = null;

    #[ORM\Column(name: 'OBSERVATION', type: 'text', nullable: true)]
    private ?string $OBSERVATION = null;

    #[ORM\Column(length: 4, nullable: true)]
    private ?string $code_iata = null;

    #[ORM\OneToMany(mappedBy: 'PAYBANQUE', targetEntity: Banque::class)]
    private Collection $banques;

    #[ORM\OneToMany(targetEntity: Vol::class, mappedBy: 'IDPAYS')]
    private Collection $vols;

    public function __construct()
    {
        $this->ORDRE = 0;
        $this->CONTINENT = '';
        $this->vols = new ArrayCollection();
    }

    public function getOBSERVATION(): ?string
    {
        return $this->OBSERVATION;
    }

    public function setOBSERVATION(?string $OBSERVATION): self
    {
        $this->OBSERVATION = $OBSERVATION;
        return $this;
    }

    public function getFORMALITE(): ?string
    {
        return $this->FORMALITE;
    }

    public function setFORMALITE(?string $FORMALITE): self
    {
        $this->FORMALITE = $FORMALITE;
        return $this;
    }

    // Getters et setters
    public function getIDPAYS(): ?int { return $this->IDPAYS; }

    public function getCODEPAYS(): ?string { return $this->CODEPAYS; }
    public function setCODEPAYS(string $CODEPAYS): self { $this->CODEPAYS = $CODEPAYS; return $this; }

    public function getLIBPAYS(): ?string { return $this->LIBPAYS; }
    public function setLIBPAYS(string $LIBPAYS): self { $this->LIBPAYS = $LIBPAYS; return $this; }

    public function getPLACE(): ?string { return $this->PLACE; }
    public function setPLACE(string $PLACE): self { $this->PLACE = $PLACE; return $this; }

    public function getORDRE(): ?string { return $this->ORDRE; }
    public function setORDRE(string $ORDRE): self { $this->ORDRE = $ORDRE; return $this; }

    public function getNATURE(): ?string { return $this->NATURE; }
    public function setNATURE(string $NATURE): self { $this->NATURE = $NATURE; return $this; }

    public function getCONTINENT(): ?string { return $this->CONTINENT; }
    public function setCONTINENT(string $CONTINENT): self { $this->CONTINENT = $CONTINENT; return $this; }

    public function getCodeIata(): ?string
    {
        return $this->code_iata;
    }

    public function setCodeIata(?string $code_iata): static
    {
        $this->code_iata = $code_iata;

        return $this;
    }
    public function __toString(): string
    {
        return $this->getLIBPAYS(); // Remplacez getLibelle() par la propriété que vous voulez afficher
    }

    /**
     * @return Collection<int, Vol>
     */
    public function getVols(): Collection
    {
        return $this->vols;
    }

    public function addVol(Vol $vol): static
    {
        if (!$this->vols->contains($vol)) {
            $this->vols->add($vol);
            $vol->setIDPAYS($this);
        }

        return $this;
    }

    public function removeVol(Vol $vol): static
    {
        if ($this->vols->removeElement($vol)) {
            // set the owning side to null (unless already changed)
            if ($vol->getIDPAYS() === $this) {
                $vol->setIDPAYS(null);
            }
        }

        return $this;
    }


}
