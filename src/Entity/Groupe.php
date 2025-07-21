<?php
// src/Entity/Groupe.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: 'App\Repository\GroupeRepository')]
#[ORM\Table(name: 'GROUPE')]
class Groupe
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'SEQGROUPE', type: Types::INTEGER)]
    private ?int $seqgroupe = null;

    #[ORM\Column(name: 'LIBGROUPE', type: Types::STRING, length: 20, unique: true)]
    private string $libgroupe = '';

    #[ORM\Column(name: 'PRINCIPAL', type: Types::STRING, length: 5)]
    private string $principal = '';


    // Getters et Setters
    public function getSeqgroupe(): ?int
    {
        return $this->seqgroupe;
    }

    public function getLibgroupe(): string
    {
        return $this->libgroupe;
    }

    public function setLibgroupe(string $libgroupe): self
    {
        $this->libgroupe = $libgroupe;
        return $this;
    }

    public function getPrincipal(): string
    {
        return $this->principal;
    }

    public function setPrincipal(string $principal): self
    {
        $this->principal = $principal;
        return $this;
    }



    public function __toString(): string
    {
        return $this->libgroupe;
    }
}