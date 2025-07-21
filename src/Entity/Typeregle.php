<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'TYPEREGLE')]
class Typeregle
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'SEQTYPEREGLE', type: 'integer')]
    private ?int $seqtyperegle = null;

    #[ORM\Column(name: 'LIBTYPEREGLE', type: 'string', length: 30)]
    private ?string $libtyperegle = null;

    #[ORM\Column(name: 'CONTREPARTIE', type: 'string', length: 8)]
    private ?string $contrepartie = null;

    #[ORM\Column(name: 'COMPTABILISABLE', type: 'string', length: 1)]
    private ?string $comptabilisable = null;

    #[ORM\Column(name: 'JOURNAL', type: 'string', length: 8)]
    private ?string $journal = null;

    #[ORM\Column(name: 'SENS', type: 'string', length: 1)]
    private ?string $sens = null;


    // Getters et Setters


    public function getSeqtyperegle(): ?int
    {
        return $this->seqtyperegle;
    }

    public function getLibtyperegle(): ?string
    {
        return $this->libtyperegle;
    }

    public function setLibtyperegle(string $libtyperegle): self
    {
        $this->libtyperegle = $libtyperegle;
        return $this;
    }

    public function getContrepartie(): ?string
    {
        return $this->contrepartie;
    }

    public function setContrepartie(string $contrepartie): self
    {
        $this->contrepartie = $contrepartie;
        return $this;
    }

    public function getComptabilisable(): ?string
    {
        return $this->comptabilisable;
    }

    public function setComptabilisable(string $comptabilisable): self
    {
        $this->comptabilisable = $comptabilisable;
        return $this;
    }

    public function getJournal(): ?string
    {
        return $this->journal;
    }

    public function setJournal(string $journal): self
    {
        $this->journal = $journal;
        return $this;
    }

    public function getSens(): ?string
    {
        return $this->sens;
    }

    public function setSens(string $sens): self
    {
        $this->sens = $sens;
        return $this;
    }
    public function __toString(): string
    {
        return $this->libtyperegle ?? '';
    }


}
