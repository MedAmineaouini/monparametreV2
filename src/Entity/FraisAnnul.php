<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Repository\FraisAnnulRepository;

#[ORM\Entity(repositoryClass: FraisAnnulRepository::class)]
#[ORM\Table(name: 'FRAISANNUL')]
class FraisAnnul
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'SEQANNUL', type: 'integer')]
    private ?int $seqannul = null;

    #[ORM\Column(name: 'JOUR1', type: 'integer')]
    private int $jour1;

    #[ORM\Column(name: 'JOUR2', type: 'integer')]
    private int $jour2;

    #[ORM\Column(name: 'FACTEUR', type: 'decimal', precision: 7, scale: 2)]
    private string $facteur;

    #[ORM\Column(name: 'TYPEANNUL', type: 'integer')]
    private int $typeannul;

    #[ORM\Column(name: 'LIBELLE', type: 'string', length: 100)]
    private string $libelle;

    #[ORM\Column(name: 'BAREME', type: 'integer')]
    private int $bareme;

    #[ORM\Column(name: 'MONTANTMINI', type: 'decimal', precision: 7, scale: 2)]
    private string $montantmini;

    #[ORM\Column(name: 'APPLICABLE', type: 'integer')]
    private int $applicable;

    public function __construct()
    {
        $this->jour1 = 0;
        $this->jour2 = 0;
        $this->facteur = '0.00';
        $this->typeannul = 0;
        $this->libelle = '';
        $this->bareme = 0;
        $this->montantmini = '0.00';
        $this->applicable = 0;
    }
    public function getSeqannul(): ?int
    {
        return $this->seqannul;
    }

    public function getJour1(): int
    {
        return $this->jour1;
    }

    public function setJour1(int $jour1): self
    {
        $this->jour1 = $jour1;
        return $this;
    }

    public function getJour2(): int
    {
        return $this->jour2;
    }

    public function setJour2(int $jour2): self
    {
        $this->jour2 = $jour2;
        return $this;
    }

    public function getFacteur(): string
    {
        return $this->facteur;
    }

    public function setFacteur(string $facteur): self
    {
        $this->facteur = $facteur;
        return $this;
    }

    public function getTypeannul(): int
    {
        return $this->typeannul;
    }

    public function setTypeannul(int $typeannul): self
    {
        $this->typeannul = $typeannul;
        return $this;
    }

    public function getLibelle(): string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;
        return $this;
    }

    public function getBareme(): int
    {
        return $this->bareme;
    }

    public function setBareme(int $bareme): self
    {
        $this->bareme = $bareme;
        return $this;
    }

    public function getMontantmini(): string
    {
        return $this->montantmini;
    }

    public function setMontantmini(string $montantmini): self
    {
        $this->montantmini = $montantmini;
        return $this;
    }

    public function getApplicable(): int
    {
        return $this->applicable;
    }

    public function setApplicable(int $applicable): self
    {
        $this->applicable = $applicable;
        return $this;
    }
} 