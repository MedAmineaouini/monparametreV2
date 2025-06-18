<?php
// src/Entity/Assur.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'ASSUR')]
class Assur
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'SEQASSUR', type: 'integer')]
    private ?int $seqassur = null;

    #[ORM\Column(name: 'LIBASSUR', type: 'string', length: 40)]
    private ?string $libassur = null;

    #[ORM\Column(name: 'TOTAL1', type: 'decimal', precision: 7, scale: 2)]
    private ?string $total1 = null;

    #[ORM\Column(name: 'TOTAL2', type: 'decimal', precision: 7, scale: 2)]
    private ?string $total2 = null;

    #[ORM\Column(name: 'TYPEVALEUR', type: 'decimal', precision: 1, scale: 0)]
    private ?string $typevaleur = null;

    #[ORM\Column(name: 'VALEUR', type: 'decimal', precision: 7, scale: 2)]
    private ?string $valeur = null;

    #[ORM\Column(name: 'PRIXVENTE', type: 'decimal', precision: 7, scale: 2)]
    private ?string $prixvente = null;

    #[ORM\Column(name: 'PRIXVENTE2', type: 'decimal', precision: 7, scale: 2)]
    private ?string $prixvente2 = null;

    #[ORM\Column(name: 'Prixachat', type: 'decimal', precision: 7, scale: 2)]
    private ?string $prixachat = null;

    #[ORM\Column(name: 'Prixachat2', type: 'decimal', precision: 7, scale: 2)]
    private ?string $prixachat2 = null;

    #[ORM\Column(name: 'MINI1', type: 'integer')]
    private ?int $mini1 = null;

    #[ORM\Column(name: 'MAXI1', type: 'integer')]
    private ?int $maxi1 = null;

    #[ORM\Column(name: 'VALEUR_achat', type: 'decimal', precision: 7, scale: 2)]
    private ?string $valeurAchat = null;


    public function __construct()
    {
        $this->libassur = '';
        $this->total1 = '0.00';
        $this->total2 = '0.00';
        $this->typevaleur = '0';
        $this->valeur = '0.00';
        $this->prixvente = '0.00';
        $this->prixvente2 = '0.00';
        $this->prixachat = '0.00';
        $this->prixachat2 = '0.00';
        $this->mini1 = 0;
        $this->maxi1 = 0;
        $this->valeurAchat = '0.00';
    }
// Getters et Setters...

    public function getSeqassur(): ?int
    {
        return $this->seqassur;
    }

    public function getLibassur(): ?string
    {
        return $this->libassur;
    }

    public function setLibassur(string $libassur): static
    {
        $this->libassur = $libassur;
        return $this;
    }

    public function getTotal1(): ?string
    {
        return $this->total1;
    }

    public function setTotal1(string $total1): static
    {
        $this->total1 = $total1;
        return $this;
    }

    public function getTotal2(): ?string
    {
        return $this->total2;
    }

    public function setTotal2(string $total2): static
    {
        $this->total2 = $total2;
        return $this;
    }

    public function getTypevaleur(): ?string
    {
        return $this->typevaleur;
    }

    public function setTypevaleur(string $typevaleur): static
    {
        $this->typevaleur = $typevaleur;
        return $this;
    }

    public function getValeur(): ?string
    {
        return $this->valeur;
    }

    public function setValeur(string $valeur): static
    {
        $this->valeur = $valeur;
        return $this;
    }

    public function getPrixvente(): ?string
    {
        return $this->prixvente;
    }

    public function setPrixvente(string $prixvente): static
    {
        $this->prixvente = $prixvente;
        return $this;
    }

    public function getPrixvente2(): ?string
    {
        return $this->prixvente2;
    }

    public function setPrixvente2(string $prixvente2): static
    {
        $this->prixvente2 = $prixvente2;
        return $this;
    }

    public function getPrixachat(): ?string
    {
        return $this->prixachat;
    }

    public function setPrixachat(string $prixachat): static
    {
        $this->prixachat = $prixachat;
        return $this;
    }

    public function getPrixachat2(): ?string
    {
        return $this->prixachat2;
    }

    public function setPrixachat2(string $prixachat2): static
    {
        $this->prixachat2 = $prixachat2;
        return $this;
    }

    public function getMini1(): ?int
    {
        return $this->mini1;
    }

    public function setMini1(int $mini1): static
    {
        $this->mini1 = $mini1;
        return $this;
    }

    public function getMaxi1(): ?int
    {
        return $this->maxi1;
    }

    public function setMaxi1(int $maxi1): static
    {
        $this->maxi1 = $maxi1;
        return $this;
    }

    public function getValeurAchat(): ?string
    {
        return $this->valeurAchat;
    }

    public function setValeurAchat(string $valeurAchat): static
    {
        $this->valeurAchat = $valeurAchat;
        return $this;
    }
}
