<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'TYPECHAMBRE')]
class Typechambre
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'SEQTYPECHAMBRE', type: 'integer')]
    private ?int $seqtypechambre = null;

    #[ORM\Column(name: 'LIBTYPECHAMBRE', type: 'string', length: 50)]
    private string $libtypechambre;

    #[ORM\Column(name: 'LIBTYPECHAMBRE2', type: 'string', length: 50)]
    private string $libtypechambre2;

    #[ORM\Column(name: 'ADULTES_MINI', type: 'integer')]
    private int $adultesMini;

    #[ORM\Column(name: 'ADULTES_MAXI', type: 'integer')]
    private int $adultesMaxi;

    #[ORM\Column(name: 'ENFANTS_MINI', type: 'integer')]
    private int $enfantsMini;

    #[ORM\Column(name: 'ENFANTS_MAXI', type: 'integer')]
    private int $enfantsMaxi;

    #[ORM\Column(name: 'BEBES_MAXI', type: 'integer')]
    private int $bebesMaxi;

    #[ORM\Column(name: 'SUPPSG', type: 'integer')]
    private int $suppsg;

    #[ORM\Column(name: 'CAPACITE', type: 'integer')]
    private int $capacite;

    #[ORM\Column(name: 'SEL', type: 'boolean')]
    private bool $sel;

    #[ORM\Column(name: 'ABRTYPECHAMBRE', type: 'string', length: 10)]
    private string $abrtypechambre;

    #[ORM\Column(name: 'ORDRE', type: 'integer')]
    private int $ordre;

    public function __construct()
    {
        $this->libtypechambre = ' ';
        $this->libtypechambre2 = ' ';
        $this->adultesMini = 0;
        $this->adultesMaxi = 0;
        $this->enfantsMini = 0;
        $this->enfantsMaxi = 0;
        $this->bebesMaxi = 0;
        $this->suppsg = 0;
        $this->capacite = 0;
        $this->sel = false;
        $this->abrtypechambre = ' ';
        $this->ordre = 0;
    }

    // Getters et Setters...

    public function getSeqtypechambre(): ?int
    {
        return $this->seqtypechambre;
    }


    public function setSeqtypechambre(?int $seqtypechambre): void
    {
        $this->seqtypechambre = $seqtypechambre;
    }


    public function getLibtypechambre(): string
    {
        return $this->libtypechambre;
    }


    public function setLibtypechambre(string $libtypechambre): void
    {
        $this->libtypechambre = $libtypechambre;
    }


    public function getLibtypechambre2(): string
    {
        return $this->libtypechambre2;
    }

    public function setLibtypechambre2(string $libtypechambre2): void
    {
        $this->libtypechambre2 = $libtypechambre2;
    }


    public function getAdultesMini(): int
    {
        return $this->adultesMini;
    }

    public function setAdultesMini(int $adultesMini): void
    {
        $this->adultesMini = $adultesMini;
    }

    public function getAdultesMaxi(): int
    {
        return $this->adultesMaxi;
    }


    public function setAdultesMaxi(int $adultesMaxi): void
    {
        $this->adultesMaxi = $adultesMaxi;
    }


    public function getEnfantsMini(): int
    {
        return $this->enfantsMini;
    }


    public function setEnfantsMini(int $enfantsMini): void
    {
        $this->enfantsMini = $enfantsMini;
    }

    public function getEnfantsMaxi(): int
    {
        return $this->enfantsMaxi;
    }


    public function setEnfantsMaxi(int $enfantsMaxi): void
    {
        $this->enfantsMaxi = $enfantsMaxi;
    }

    public function getBebesMaxi(): int
    {
        return $this->bebesMaxi;
    }

    public function setBebesMaxi(int $bebesMaxi): void
    {
        $this->bebesMaxi = $bebesMaxi;
    }

    public function getSuppsg(): int
    {
        return $this->suppsg;
    }


    public function setSuppsg(int $suppsg): void
    {
        $this->suppsg = $suppsg;
    }

    public function getCapacite(): int
    {
        return $this->capacite;
    }


    public function setCapacite(int $capacite): void
    {
        $this->capacite = $capacite;
    }

    public function isSel(): bool
    {
        return $this->sel;
    }

    public function setSel(bool $sel): void
    {
        $this->sel = $sel;
    }


    public function getAbrtypechambre(): string
    {
        return $this->abrtypechambre;
    }


    public function setAbrtypechambre(string $abrtypechambre): void
    {
        $this->abrtypechambre = $abrtypechambre;
    }


    public function getOrdre(): int
    {
        return $this->ordre;
    }


    public function setOrdre(int $ordre): void
    {
        $this->ordre = $ordre;
    }




}
