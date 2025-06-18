<?php

namespace App\Entity;

use App\Repository\PrestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrestRepository::class)]
#[ORM\Table(name: "PREST")]
class Prest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "SEQPREST", type: "integer")]
    private ?int $SEQPREST = null;

    #[ORM\Column(name: "LIBPREST", type: "string", length: 80, nullable: true)]
    private ?string $LIBPREST = null;

    #[ORM\Column(name: "CODEPREST", type: "string", length: 14, nullable: true)]
    private ?string $CODEPREST = null;

    #[ORM\Column(name: "ACTIVER", type: "boolean", nullable: true)]
    private ?bool $ACTIVER = null;

    public function __construct()
    {
        $this->LIBPREST = '';
        $this->CODEPREST = '';
        $this->ACTIVER = false;
    }

    // === GETTERS & SETTERS ===

    public function getSEQPREST(): ?int
    {
        return $this->SEQPREST;
    }

    public function getLIBPREST(): ?string
    {
        return $this->LIBPREST;
    }

    public function setLIBPREST(?string $LIBPREST): self
    {
        $this->LIBPREST = $LIBPREST ?? '';

        return $this;
    }

    public function getCODEPREST(): ?string
    {
        return $this->CODEPREST;
    }

    public function setCODEPREST(?string $CODEPREST): self
    {
        $this->CODEPREST = $CODEPREST ?? '';

        return $this;
    }

    public function isACTIVER(): ?bool
    {
        return $this->ACTIVER;
    }

    public function setACTIVER(?bool $ACTIVER): self
    {
        $this->ACTIVER = $ACTIVER ?? false;

        return $this;
    }
}
