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

}
