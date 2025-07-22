<?php
// src/Entity/Regletarifaire.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "App\Repository\RegletarifaireRepository")]
#[ORM\Table(name: "REGLETARIFAIRE")]
class Regletarifaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "SEQREGLETARIFAIRE", type: "integer")]
    private ?int $seqregletarifaire = null;

    #[ORM\Column(name: "LIBREGLE", type: "string", length: 80)]
    private string $libregle;

    // Getters et Setters
    public function getSeqregletarifaire(): ?int
    {
        return $this->seqregletarifaire;
    }

    public function getLibregle(): string
    {
        return $this->libregle;
    }

    public function setLibregle(string $libregle): self
    {
        $this->libregle = $libregle;
        return $this;
    }

    // Méthode magique pour l'affichage
    public function __toString(): string
    {
        return $this->libregle;
    }
}