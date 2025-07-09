<?php

namespace App\Entity;

use App\Repository\BaseCureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BaseCureRepository::class)]
#[ORM\Table(name: 'BASE_CURE')]
class BaseCure
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'SEQCURE', type: 'integer')]
    private ?int $seqcure = null;  // Initialisé à null

    #[ORM\Column(name: 'CODELIBCURE', type: 'string', length: 6, options: ['default' => ''])]
    private string $codelibcure = '';

    #[ORM\Column(name: 'seq', type: 'integer', options: ['default' => 0])]
    private int $seq = 0;

    #[ORM\Column(name: 'LIBELLE_CURE', type: 'string', length: 60, nullable: true)]
    private ?string $libelleCure = null;

    #[ORM\Column(name: 'TYPECURE', type: 'string', length: 25, options: ['default' => ''])]
    private string $typecure = '';

    #[ORM\Column(name: 'ANCIEN', type: 'string', length: 5, options: ['default' => ''])]
    private string $ancien = '';

    #[ORM\Column(name: 'ARCHIVER', type: 'boolean', options: ['default' => false])]
    private bool $archiver = false;

    #[ORM\Column(name: 'SEQTYPECURE', type: 'integer', options: ['default' => 0])]
    private int $seqtypecure = 0;

    #[ORM\Column(name: 'LIBTYPECURE', type: 'string', length: 30, options: ['default' => ''])]
    private string $libtypecure = '';

    /**
     * @return int|null
     */
    public function getSeqcure(): ?int
    {
        return $this->seqcure;
    }

    /**
     * @param int|null $seqcure
     */
    public function setSeqcure(?int $seqcure): void
    {
        $this->seqcure = $seqcure;
    }

    /**
     * @return string
     */
    public function getCodelibcure(): string
    {
        return $this->codelibcure;
    }

    /**
     * @param string $codelibcure
     */
    public function setCodelibcure(string $codelibcure): void
    {
        $this->codelibcure = $codelibcure;
    }

    /**
     * @return int
     */
    public function getSeq(): int
    {
        return $this->seq;
    }

    /**
     * @param int $seq
     */
    public function setSeq(int $seq): void
    {
        $this->seq = $seq;
    }

    /**
     * @return string|null
     */
    public function getLibelleCure(): ?string
    {
        return $this->libelleCure;
    }

    /**
     * @param string|null $libelleCure
     */
    public function setLibelleCure(?string $libelleCure): void
    {
        $this->libelleCure = $libelleCure;
    }

    /**
     * @return string
     */
    public function getTypecure(): string
    {
        return $this->typecure;
    }

    /**
     * @param string $typecure
     */
    public function setTypecure(string $typecure): void
    {
        $this->typecure = $typecure;
    }

    /**
     * @return string
     */
    public function getAncien(): string
    {
        return $this->ancien;
    }

    /**
     * @param string $ancien
     */
    public function setAncien(string $ancien): void
    {
        $this->ancien = $ancien;
    }

    /**
     * @return bool
     */
    public function isArchiver(): bool
    {
        return $this->archiver;
    }

    /**
     * @param bool $archiver
     */
    public function setArchiver(bool $archiver): void
    {
        $this->archiver = $archiver;
    }

    /**
     * @return int
     */
    public function getSeqtypecure(): int
    {
        return $this->seqtypecure;
    }

    /**
     * @param int $seqtypecure
     */
    public function setSeqtypecure(int $seqtypecure): void
    {
        $this->seqtypecure = $seqtypecure;
    }

    /**
     * @return string
     */
    public function getLibtypecure(): string
    {
        return $this->libtypecure;
    }

    /**
     * @param string $libtypecure
     */
    public function setLibtypecure(string $libtypecure): void
    {
        $this->libtypecure = $libtypecure;
    }

    // Getters et setters inchangés...
    
}