<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: "App\Repository\GroupementClientRepository")]
#[ORM\Table(name: 'GROUPEMENTCLIENT')]
class GroupementClient
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'SEQGROUPEMENTCLIENT', type: 'integer')]
    private ?int $seqgroupementclient = null;

    #[ORM\Column(name: 'GROUPECLIENT', type: 'string', length: 10, unique: true)]
    #[Assert\NotBlank(message: "Le code du groupement est obligatoire")]
    #[Assert\Length(
        max: 10,
        maxMessage: "Le code ne doit pas dépasser {{ limit }} caractères"
    )]
    private string $groupeclient = '';

    #[ORM\Column(name: 'NOMGROUPECLIENT', type: 'string', length: 30)]
    #[Assert\NotBlank(message: "Le nom du groupement est obligatoire")]
    #[Assert\Length(
        max: 30,
        maxMessage: "Le nom ne doit pas dépasser {{ limit }} caractères"
    )]
    private string $nomgroupeclient = '';

    #[ORM\Column(name: 'ARCHIVER', type: 'boolean')]
    private bool $archiver = false;

    // Getters and Setters

    public function getSeqgroupementclient(): ?int
    {
        return $this->seqgroupementclient;
    }

    public function getGroupeclient(): string
    {
        return $this->groupeclient;
    }

    public function setGroupeclient(string $groupeclient): self
    {
        $this->groupeclient = $groupeclient;
        return $this;
    }

    public function getNomgroupeclient(): string
    {
        return $this->nomgroupeclient;
    }

    public function setNomgroupeclient(string $nomgroupeclient): self
    {
        $this->nomgroupeclient = $nomgroupeclient;
        return $this;
    }

    public function isArchiver(): bool
    {
        return $this->archiver;
    }

    public function setArchiver(bool $archiver): self
    {
        $this->archiver = $archiver;
        return $this;
    }

    // Méthode pour faciliter l'affichage
    public function __toString(): string
    {
        return $this->nomgroupeclient;
    }
}