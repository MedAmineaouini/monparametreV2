<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Pays;
use App\Entity\Souspays;

#[ORM\Entity]
#[ORM\Table(name: 'VILLE')]
class Ville
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'SEQVILLE', type: 'integer')]
    private ?int $seqville = null;

    #[ORM\Column(name: 'CODEVILLE', type: 'string', length: 3)]
    private string $codeville;

    #[ORM\Column(name: 'AERO', type: 'string', length: 3)]
    private string $aero;

    #[ORM\Column(name: 'LIBVILLE', type: 'string', length: 40)]
    private string $libville;

    #[ORM\ManyToOne(targetEntity: Pays::class, inversedBy: 'villes')]
    #[ORM\JoinColumn(name: 'IDPAYS', referencedColumnName: 'IDPAYS', nullable: false)]
    private ?Pays $pays = null;

    #[ORM\Column(name: 'CODEIATA', type: 'string', length: 3)]
    private string $codeiata;

    #[ORM\Column(name: 'seq_zone', type: 'integer')]
    private int $seq_zone;

    #[ORM\Column(name: 'IATAAERO', type: 'string', length: 3)]
    private string $iataaero;

    #[ORM\ManyToOne(targetEntity: Souspays::class, inversedBy: 'villes')]
    #[ORM\JoinColumn(name: 'SEQSOUSPAYS', referencedColumnName: 'SEQSOUSPAYS', nullable: false)]
    private ?Souspays $souspays = null;

    #[ORM\Column(name: 'SEQVILLEPARENT', type: 'integer')]
    private int $seqvilleparent;

    #[ORM\Column(name: 'Taxe_B2B', type: 'decimal', precision: 7, scale: 2)]
    private string $taxe_b2b;

    public function __construct()
    {
        $this->codeville = '';
        $this->aero = '';
        $this->libville = '';
        $this->codeiata = '';
        $this->seq_zone = 0;
        $this->iataaero = '';
        $this->seqvilleparent = 0;
        $this->taxe_b2b = '0.00';
    }

    // Getters and setters

    public function getSeqville(): ?int
    {
        return $this->seqville;
    }

    public function setSeqville(?int $seqville): self
    {
        $this->seqville = $seqville;
        return $this;
    }

    public function getCodeville(): string
    {
        return $this->codeville;
    }

    public function setCodeville(string $codeville): self
    {
        $this->codeville = $codeville;
        return $this;
    }

    public function getAero(): string
    {
        return $this->aero;
    }

    public function setAero(string $aero): self
    {
        $this->aero = $aero;
        return $this;
    }

    public function getLibville(): string
    {
        return $this->libville;
    }

    public function setLibville(string $libville): self
    {
        $this->libville = $libville;
        return $this;
    }

    public function getPays(): ?Pays
    {
        return $this->pays;
    }

    public function setPays(?Pays $pays): self
    {
        $this->pays = $pays;
        return $this;
    }

    public function getCodeiata(): string
    {
        return $this->codeiata;
    }

    public function setCodeiata(string $codeiata): self
    {
        $this->codeiata = $codeiata;
        return $this;
    }

    public function getSeqZone(): int
    {
        return $this->seq_zone;
    }

    public function setSeqZone(int $seq_zone): self
    {
        $this->seq_zone = $seq_zone;
        return $this;
    }

    public function getIataaero(): string
    {
        return $this->iataaero;
    }

    public function setIataaero(string $iataaero): self
    {
        $this->iataaero = $iataaero;
        return $this;
    }

    public function getSouspays(): ?Souspays
    {
        return $this->souspays;
    }

    public function setSouspays(?Souspays $souspays): self
    {
        $this->souspays = $souspays;
        return $this;
    }

    public function getSeqvilleparent(): int
    {
        return $this->seqvilleparent;
    }

    public function setSeqvilleparent(int $seqvilleparent): self
    {
        $this->seqvilleparent = $seqvilleparent;
        return $this;
    }

    public function getTaxeB2b(): string
    {
        return $this->taxe_b2b;
    }

    public function setTaxeB2b(string $taxe_b2b): self
    {
        $this->taxe_b2b = $taxe_b2b;
        return $this;
    }

    public function __toString(): string
{
    return $this->libville ?? ''; 
}

}