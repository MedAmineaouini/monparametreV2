<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\TypeCltRepository')]
#[ORM\Table(name: 'TYPECLT')]
class TypeClt
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'SEQTYPECLT', type: 'integer')]
    private ?int $seqtypeclt = null;

    #[ORM\Column(name: 'LIBTYPECLT', type: 'string', length: 60, unique: true, options: ['default' => ''])]
    private string $libtypeclt = '';

    #[ORM\Column(name: 'DEPART', type: 'integer', options: ['default' => 0])]
    private int $depart = 0;

    #[ORM\Column(name: 'JOURFIXE', type: 'integer', options: ['default' => 0])]
    private int $jourFixe = 0;

    #[ORM\Column(name: 'MOISPLUS', type: 'integer', options: ['default' => 0])]
    private int $moisPlus = 0;

    #[ORM\Column(name: 'RESERVATION', type: 'integer', options: ['default' => 0])]
    private int $reservation = 0;

    #[ORM\Column(name: 'DATEFIXE', type: 'integer', options: ['default' => 0])]
    private int $dateFixe = 0;

    #[ORM\Column(name: 'ECHANCEMENT', type: 'string', length: 12, options: ['default' => ''], nullable: false)]
    #[Assert\NotBlank(message: 'L\'échéancement est obligatoire')]
    private string $echeancement = '';
    // Getters and Setters

    public function getSeqtypeclt(): ?int
    {
        return $this->seqtypeclt;
    }

    public function getLibtypeclt(): string
    {
        return $this->libtypeclt;
    }

    public function setLibtypeclt(string $libtypeclt): self
    {
        $this->libtypeclt = $libtypeclt;
        return $this;
    }

    public function getDepart(): int
    {
        return $this->depart;
    }

    public function setDepart(int $depart): self
    {
        $this->depart = $depart;
        return $this;
    }

    public function getJourFixe(): int
    {
        return $this->jourFixe;
    }

    public function setJourFixe(int $jourFixe): self
    {
        $this->jourFixe = $jourFixe;
        return $this;
    }

    public function getMoisPlus(): int
    {
        return $this->moisPlus;
    }

    public function setMoisPlus(int $moisPlus): self
    {
        $this->moisPlus = $moisPlus;
        return $this;
    }

    public function getReservation(): int
    {
        return $this->reservation;
    }

    public function setReservation(int $reservation): self
    {
        $this->reservation = $reservation;
        return $this;
    }

    public function getDateFixe(): int
    {
        return $this->dateFixe;
    }

    public function setDateFixe(int $dateFixe): self
    {
        $this->dateFixe = $dateFixe;
        return $this;
    }

    public function getEcheancement(): string
    {
        return $this->echeancement;
    }

    public function setEcheancement(string $echeancement): self
    {
        $this->echeancement = $echeancement;
        return $this;
    }
    public function __toString(): string
    {
        return (string) $this->getlibtypeclt(); // Or whatever property you want to display
    }
}