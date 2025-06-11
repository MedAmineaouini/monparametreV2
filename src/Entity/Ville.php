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

    #[ORM\ManyToOne(targetEntity: Pays::class)]
    #[ORM\JoinColumn(name: 'IDPAYS', referencedColumnName: 'IDPAYS', nullable: false)]
    private ?Pays $pays = null;

    #[ORM\Column(name: 'CODEIATA', type: 'string', length: 3)]
    private string $codeiata;

    #[ORM\Column(name: 'seq_zone', type: 'integer')]
    private int $seq_zone;

    #[ORM\Column(name: 'IATAAERO', type: 'string', length: 3)]
    private string $iataaero;

    #[ORM\ManyToOne(targetEntity: Souspays::class)]
    #[ORM\JoinColumn(name: 'SEQSOUSPAYS', referencedColumnName: 'SEQSOUSPAYS', nullable: false)]
    private ?Souspays $souspays = null;

    #[ORM\Column(name: 'SEQVILLEPARENT', type: 'integer')]
    private int $seqvilleparent;

    #[ORM\Column(name: 'Taxe_B2B', type: 'decimal', precision: 7, scale: 2)]
    private string $taxe_b2b;

    // Getters and setters

    public function getSeqville(): ?int
    {
        return $this->seqville;
    }

    public function setSeqville(?int $seqville): void
    {
        $this->seqville = $seqville;
    }

    public function getCodeville(): string
    {
        return $this->codeville;
    }

    public function setCodeville(string $codeville): void
    {
        $this->codeville = $codeville;
    }

    public function getAero(): string
    {
        return $this->aero;
    }

    public function setAero(string $aero): void
    {
        $this->aero = $aero;
    }

    public function getLibville(): string
    {
        return $this->libville;
    }

    public function setLibville(string $libville): void
    {
        $this->libville = $libville;
    }

    public function getPays(): ?Pays
    {
        return $this->pays;
    }

    public function setPays(?Pays $pays): void
    {
        $this->pays = $pays;
    }

    public function getCodeiata(): string
    {
        return $this->codeiata;
    }

    public function setCodeiata(string $codeiata): void
    {
        $this->codeiata = $codeiata;
    }

    public function getSeqZone(): int
    {
        return $this->seq_zone;
    }

    public function setSeqZone(int $seq_zone): void
    {
        $this->seq_zone = $seq_zone;
    }

    public function getIataaero(): string
    {
        return $this->iataaero;
    }

    public function setIataaero(string $iataaero): void
    {
        $this->iataaero = $iataaero;
    }

    public function getSouspays(): ?Souspays
    {
        return $this->souspays;
    }

    public function setSouspays(?Souspays $souspays): void
    {
        $this->souspays = $souspays;
    }

    public function getSeqvilleparent(): int
    {
        return $this->seqvilleparent;
    }

    public function setSeqvilleparent(int $seqvilleparent): void
    {
        $this->seqvilleparent = $seqvilleparent;
    }

    public function getTaxeB2b(): string
    {
        return $this->taxe_b2b;
    }

    public function setTaxeB2b(string $taxe_b2b): void
    {
        $this->taxe_b2b = $taxe_b2b;
    }
}
