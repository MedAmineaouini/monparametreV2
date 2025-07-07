<?php

namespace App\Entity;

use App\Repository\MonnaieRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Pays;

#[ORM\Entity(repositoryClass: MonnaieRepository::class)]
#[ORM\Table(name: 'MONNAIE')]
class Monnaie
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: 'SEQMONNAIE', type: Types::INTEGER)]
    private ?int $seqmonnaie = null;

    #[ORM\Column(name: 'LIBMONNAIE', type: Types::STRING, length: 3, unique: true, options: ['default' => ''])]
    private ?string $libmonnaie = '';

    #[ORM\Column(name: 'NOMMONNAIE', type: Types::STRING, length: 20, options: ['default' => ''])]
    private ?string $nommonnaie = '';

    #[ORM\Column(name: 'TAUX', type: Types::DECIMAL, precision: 9, scale: 6, options: ['default' => '0.000000'])]
    private ?string $taux = '0.000000';

    #[ORM\Column(name: 'LIBPAYS', type: Types::STRING, length: 30, options: ['default' => ''])]
    private ?string $libpays = '';

    #[ORM\Column(name: 'CALCUL', type: Types::INTEGER, options: ['default' => 0])]
    private ?int $calcul = 0;

    #[ORM\Column(name: 'DATEMAJ', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $datemaj = null;

    #[ORM\ManyToOne(targetEntity: Pays::class)]
    #[ORM\JoinColumn(name: 'IDPAYS', referencedColumnName: 'IDPAYS', nullable: false)]
    private ?Pays $pays = null;

    public function __construct()
    {
        $this->datemaj = new \DateTime(); 
    }

    // Getters and Setters

    public function getSeqmonnaie(): ?int
    {
        return $this->seqmonnaie;
    }

    public function getLibmonnaie(): ?string
    {
        return $this->libmonnaie;
    }

    public function setLibmonnaie(string $libmonnaie): static
    {
        $this->libmonnaie = $libmonnaie;
        return $this;
    }

    public function getNommonnaie(): ?string
    {
        return $this->nommonnaie;
    }

    public function setNommonnaie(string $nommonnaie): static
    {
        $this->nommonnaie = $nommonnaie;
        return $this;
    }

    public function getTaux(): ?string
    {
        return $this->taux;
    }

    public function setTaux(string $taux): static
    {
        $this->taux = $taux;
        return $this;
    }

    public function getLibpays(): ?string
    {
        return $this->libpays;
    }

    public function setLibpays(string $libpays): static
    {
        $this->libpays = $libpays;
        return $this;
    }

    public function getCalcul(): ?int
    {
        return $this->calcul;
    }

    public function setCalcul(int $calcul): static
    {
        $this->calcul = $calcul;
        return $this;
    }

    public function getDatemaj(): ?\DateTimeInterface
    {
        return $this->datemaj;
    }

    public function setDatemaj(\DateTimeInterface $datemaj): static
    {
        $this->datemaj = $datemaj;
        return $this;
    }

    public function getPays(): ?Pays
    {
        return $this->pays;
    }

    public function setPays(Pays $pays): static
    {
        $this->pays = $pays;
        return $this;
    }
}
