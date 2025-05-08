<?php

namespace App\Entity;

use App\Repository\PaysRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaysRepository::class)]
#[ORM\Table(name: 'PAYS')]
class Pays
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'IDPAYS', type: 'integer')]
    private ?int $IDPAYS = null;

    #[ORM\Column(name: 'CODEPAYS', type: 'string', length: 2)]
    private ?string $CODEPAYS = null;

    #[ORM\Column(name: 'LIBPAYS', type: 'string', length: 30)]
    private ?string $LIBPAYS = null;

    #[ORM\Column(name: 'PLACE', type: 'string', length: 8)]
    private ?string $PLACE = null;

    #[ORM\Column(name: 'ORDRE', type: 'decimal', precision: 2, scale: 0)]
    private ?string $ORDRE = null;

    #[ORM\Column(name: 'NATURE', type: 'decimal', precision: 1, scale: 0)]
    private ?string $NATURE = null;

    #[ORM\Column(name: 'CONTINENT', type: 'string', length: 10)]
    private ?string $CONTINENT = null;

    // Getters et setters
    public function getIDPAYS(): ?int { return $this->IDPAYS; }

    public function getCODEPAYS(): ?string { return $this->CODEPAYS; }
    public function setCODEPAYS(string $CODEPAYS): self { $this->CODEPAYS = $CODEPAYS; return $this; }

    public function getLIBPAYS(): ?string { return $this->LIBPAYS; }
    public function setLIBPAYS(string $LIBPAYS): self { $this->LIBPAYS = $LIBPAYS; return $this; }

    public function getPLACE(): ?string { return $this->PLACE; }
    public function setPLACE(string $PLACE): self { $this->PLACE = $PLACE; return $this; }

    public function getORDRE(): ?string { return $this->ORDRE; }
    public function setORDRE(string $ORDRE): self { $this->ORDRE = $ORDRE; return $this; }

    public function getNATURE(): ?string { return $this->NATURE; }
    public function setNATURE(string $NATURE): self { $this->NATURE = $NATURE; return $this; }

    public function getCONTINENT(): ?string { return $this->CONTINENT; }
    public function setCONTINENT(string $CONTINENT): self { $this->CONTINENT = $CONTINENT; return $this; }
}
