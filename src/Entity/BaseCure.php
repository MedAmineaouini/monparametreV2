<?php

namespace App\Entity;

use App\Repository\BaseCureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BaseCureRepository::class)]
#[ORM\Table(name: 'BASE_CURE')]
class BaseCure
{
    #[ORM\Id]
    #[ORM\Column(name: 'CODELIBCURE', type: 'string', length: 6, unique: true)]
    private ?string $codelibcure = '';

    #[ORM\Column(name: 'SEQCURE', type: 'integer', unique: true)]
    private ?int $seqcure = null;

    #[ORM\Column(name: 'seq', type: 'integer')]
    private ?int $seq = 0;

    #[ORM\Column(name: 'LIBELLE_CURE', type: 'string', length: 60)]
    private ?string $libelleCure = '';

    #[ORM\Column(name: 'TYPECURE', type: 'string', length: 25)]
    private ?string $typecure = '';

    #[ORM\Column(name: 'ANCIEN', type: 'string', length: 5)]
    private ?string $ancien = '';

    #[ORM\Column(name: 'ARCHIVER', type: 'boolean')]
    private ?bool $archiver = false;

    #[ORM\Column(name: 'SEQTYPECURE', type: 'integer')]
    private ?int $seqtypecure = 0;

    #[ORM\Column(name: 'LIBTYPECURE', type: 'string', length: 30)]
    private ?string $libtypecure = '';

    // Getters et Setters

    public function getCodelibcure(): ?string
    {
        return $this->codelibcure;
    }

    public function setCodelibcure(string $codelibcure): static
    {
        $this->codelibcure = $codelibcure;

        return $this;
    }

    public function getSeqcure(): ?int
    {
        return $this->seqcure;
    }

    public function setSeqcure(int $seqcure): static
    {
        $this->seqcure = $seqcure;

        return $this;
    }

    public function getSeq(): ?int
    {
        return $this->seq;
    }

    public function setSeq(int $seq): static
    {
        $this->seq = $seq;

        return $this;
    }

    public function getLibelleCure(): ?string
    {
        return $this->libelleCure;
    }

    public function setLibelleCure(string $libelleCure): static
    {
        $this->libelleCure = $libelleCure;

        return $this;
    }

    public function getTypecure(): ?string
    {
        return $this->typecure;
    }

    public function setTypecure(string $typecure): static
    {
        $this->typecure = $typecure;

        return $this;
    }

    public function getAncien(): ?string
    {
        return $this->ancien;
    }

    public function setAncien(string $ancien): static
    {
        $this->ancien = $ancien;

        return $this;
    }

    public function isArchiver(): ?bool
    {
        return $this->archiver;
    }

    public function setArchiver(bool $archiver): static
    {
        $this->archiver = $archiver;

        return $this;
    }

    public function getSeqtypecure(): ?int
    {
        return $this->seqtypecure;
    }

    public function setSeqtypecure(int $seqtypecure): static
    {
        $this->seqtypecure = $seqtypecure;

        return $this;
    }

    public function getLibtypecure(): ?string
    {
        return $this->libtypecure;
    }

    public function setLibtypecure(string $libtypecure): static
    {
        $this->libtypecure = $libtypecure;

        return $this;
    }
}