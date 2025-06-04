<?php

namespace App\Entity;

use App\Entity\Pays;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'SOUSPAYS')]
class Souspays
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'SEQSOUSPAYS', type: 'integer')]
    private ?int $seqsouspays = null;

    #[ORM\ManyToOne(targetEntity: Pays::class)]
    #[ORM\JoinColumn(name: 'IDPAYS', referencedColumnName: 'IDPAYS', nullable: false)]
    private ?Pays $pays = null;

    #[ORM\Column(name: 'LIBSOUSPAYS', type: 'string', length: 30)]
    private string $libsouspays;

    #[ORM\Column(name: 'TUN', type: 'decimal', precision: 8, scale: 2)]
    private string $tun;

    #[ORM\Column(name: 'MIR', type: 'decimal', precision: 8, scale: 2)]
    private string $mir;

    #[ORM\Column(name: 'NBE', type: 'decimal', precision: 8, scale: 2)]
    private string $nbe;

    #[ORM\Column(name: 'DJE', type: 'decimal', precision: 8, scale: 2)]
    private string $dje;

    #[ORM\Column(name: 'TOE', type: 'decimal', precision: 8, scale: 2)]
    private string $toe;

    #[ORM\Column(name: 'TUNVENTE', type: 'decimal', precision: 8, scale: 2)]
    private string $tunvente;

    #[ORM\Column(name: 'MIRVENTE', type: 'decimal', precision: 8, scale: 2)]
    private string $mirvente;

    #[ORM\Column(name: 'NBEVENTE', type: 'decimal', precision: 8, scale: 2)]
    private string $nbevente;

    #[ORM\Column(name: 'DJEVENTE', type: 'decimal', precision: 8, scale: 2)]
    private string $djevente;

    #[ORM\Column(name: 'TOEVENTE', type: 'decimal', precision: 8, scale: 2)]
    private string $toevente;

    #[ORM\Column(name: 'ORDRE', type: 'decimal', precision: 2, scale: 0, nullable: true)]
    private ?string $ordre = null;

    // Getters & Setters
    public function getSeqsouspays(): ?int
    {
        return $this->seqsouspays;
    }

    public function setSeqsouspays(?int $seqsouspays): void
    {
        $this->seqsouspays = $seqsouspays;
    }

    public function getPays(): ?Pays
    {
        return $this->pays;
    }

    public function setPays(?Pays $pays): void
    {
        $this->pays = $pays;
    }

    public function getLibsouspays(): string
    {
        return $this->libsouspays;
    }

    public function setLibsouspays(string $libsouspays): void
    {
        $this->libsouspays = $libsouspays;
    }

    public function getTun(): string
    {
        return $this->tun;
    }

    public function setTun(string $tun): void
    {
        $this->tun = $tun;
    }

    public function getMir(): string
    {
        return $this->mir;
    }

    public function setMir(string $mir): void
    {
        $this->mir = $mir;
    }

    public function getNbe(): string
    {
        return $this->nbe;
    }

    public function setNbe(string $nbe): void
    {
        $this->nbe = $nbe;
    }

    public function getDje(): string
    {
        return $this->dje;
    }

    public function setDje(string $dje): void
    {
        $this->dje = $dje;
    }

    public function getToe(): string
    {
        return $this->toe;
    }

    public function setToe(string $toe): void
    {
        $this->toe = $toe;
    }

    public function getTunvente(): string
    {
        return $this->tunvente;
    }

    public function setTunvente(string $tunvente): void
    {
        $this->tunvente = $tunvente;
    }

    public function getMirvente(): string
    {
        return $this->mirvente;
    }

    public function setMirvente(string $mirvente): void
    {
        $this->mirvente = $mirvente;
    }

    public function getNbevente(): string
    {
        return $this->nbevente;
    }

    public function setNbevente(string $nbevente): void
    {
        $this->nbevente = $nbevente;
    }

    public function getDjevente(): string
    {
        return $this->djevente;
    }

    public function setDjevente(string $djevente): void
    {
        $this->djevente = $djevente;
    }

    public function getToevente(): string
    {
        return $this->toevente;
    }

    public function setToevente(string $toevente): void
    {
        $this->toevente = $toevente;
    }

    public function getOrdre(): ?string
    {
        return $this->ordre;
    }

    public function setOrdre(?string $ordre): void
    {
        $this->ordre = $ordre;
    }
}
