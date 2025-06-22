<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FraisModifRepository")
 * @ORM\Table(name="FRAISMODIF")
 * @UniqueEntity("libelle", message="Ce libellé existe déjà.")
 */
class FraisModif
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="SEQMODIF", type="integer")
     */
    private $seqmodif;

    /**
     * @ORM\Column(name="JOUR1", type="integer")
     */
    private $jour1;

    /**
     * @ORM\Column(name="JOUR2", type="integer")
     */
    private $jour2;

    /**
     * @ORM\Column(name="FACTEUR", type="decimal", precision=7, scale=2)
     */
    private $facteur;

    /**
     * @ORM\Column(name="TYPEMODIF", type="integer")
     */
    private $typemodif;

    /**
     * @ORM\Column(name="LIBELLE", type="string", length=100, unique=true)
     */
    private $libelle;

    /**
     * @ORM\Column(name="BAREME", type="integer")
     */
    private $bareme;

    /**
     * @ORM\Column(name="MONTANTMINI", type="decimal", precision=7, scale=2)
     */
    private $montantmini;

    /**
     * @ORM\Column(name="APPLICABLE", type="integer")
     */
    private $applicable;

    public function __construct()
    {
        $this->jour1 = 0;
        $this->jour2 = 0;
        $this->facteur = '0.00';
        $this->typemodif = 0;
        $this->libelle = '';
        $this->bareme = 0;
        $this->montantmini = '0.00';
        $this->applicable = 0;
    }

    // Getters et Setters
    public function getSeqmodif(): ?int
    {
        return $this->seqmodif;
    }

    public function getJour1(): ?int
    {
        return $this->jour1;
    }

    public function setJour1(int $jour1): self
    {
        $this->jour1 = $jour1;

        return $this;
    }

    public function getJour2(): ?int
    {
        return $this->jour2;
    }

    public function setJour2(int $jour2): self
    {
        $this->jour2 = $jour2;

        return $this;
    }

    public function getFacteur(): ?string
    {
        return $this->facteur;
    }

    public function setFacteur(string $facteur): self
    {
        $this->facteur = $facteur;

        return $this;
    }

    public function getTypemodif(): ?int
    {
        return $this->typemodif;
    }

    public function setTypemodif(int $typemodif): self
    {
        $this->typemodif = $typemodif;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getBareme(): ?int
    {
        return $this->bareme;
    }

    public function setBareme(int $bareme): self
    {
        $this->bareme = $bareme;

        return $this;
    }

    public function getMontantmini(): ?string
    {
        return $this->montantmini;
    }

    public function setMontantmini(string $montantmini): self
    {
        $this->montantmini = $montantmini;

        return $this;
    }

    public function getApplicable(): ?int
    {
        return $this->applicable;
    }

    public function setApplicable(int $applicable): self
    {
        $this->applicable = $applicable;

        return $this;
    }
}