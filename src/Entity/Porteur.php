<?php

namespace App\Entity;

use App\Repository\PorteurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PorteurRepository::class)]
#[ORM\Table(name: "PORTEUR")]
class Porteur
{
    #[ORM\Id]
    #[ORM\Column(name: "SEQPORTEUR", type: "integer")]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $seqPorteur = null;

    #[ORM\Column(name: "LIBPORTEUR", type: "string", length: 30)]
    private string $libPorteur;

    #[ORM\Column(name: "CODECOMM", type: "string", length: 4)]
    private string $codeComm;

    public function __construct()
    {
        $this->libPorteur = '';
        $this->codeComm = '';
    }

    public function getSeqPorteur(): ?int
    {
        return $this->seqPorteur;
    }

    public function getLibPorteur(): string
    {
        return $this->libPorteur;
    }

    public function setLibPorteur(string $libPorteur): self
    {
        $this->libPorteur = $libPorteur;
        return $this;
    }

    public function getCodeComm(): string
    {
        return $this->codeComm;
    }

    public function setCodeComm(string $codeComm): self
    {
        $this->codeComm = $codeComm;
        return $this;
    }
}
