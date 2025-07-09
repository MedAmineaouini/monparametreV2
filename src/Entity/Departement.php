<?php

namespace App\Entity;

use App\Repository\DepartementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Region;
use App\Entity\Commercial;

#[ORM\Entity(repositoryClass: DepartementRepository::class)]
#[ORM\Table(name: 'DEPARTEMENT')]
#[UniqueEntity('codeDepartement', message: 'Ce code département existe déjà')]
class Departement
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'SEQDEPARTEMENT', type: 'integer')]
    private ?int $seqDepartement = null;

    #[ORM\Column(name: 'CODE_DEPARTEMENT', type: 'string', length: 5, unique: true)]
    #[Assert\NotBlank(message: 'Le code département est obligatoire')]
    #[Assert\Length(
        max: 5,
        maxMessage: 'Le code département ne doit pas dépasser 5 caractères'
    )]
    private string $codeDepartement = '';

    #[ORM\Column(name: 'LIB_DEPARTEMENT', type: 'string', length: 100)]
    #[Assert\NotBlank(message: 'Le libellé du département est obligatoire')]
    #[Assert\Length(
        max: 100,
        maxMessage: 'Le libellé ne doit pas dépasser 100 caractères'
    )]
    private string $libDepartement = '';

    #[ORM\Column(name: 'CODECOMMERCIAL', type: 'string', length: 4, nullable: true)]
    private ?string $codeCommercial = null;

    #[ORM\ManyToOne(targetEntity: Region::class, inversedBy: 'departements')]
    #[ORM\JoinColumn(name: 'SEQREGION', referencedColumnName: 'SEQREGION', nullable: false)]
    #[Assert\NotNull(message: 'La région est obligatoire')]
    private ?Region $region = null;

    #[ORM\ManyToOne(targetEntity: Commercial::class, inversedBy: 'departements')]
    #[ORM\JoinColumn(name: 'SEQCOMMERCIAL', referencedColumnName: 'SEQCOMMERCIAL', nullable: true)]
    private ?Commercial $commercial = null;

    // Getters et Setters

    public function getSeqDepartement(): ?int
    {
        return $this->seqDepartement;
    }

    public function getCodeDepartement(): string
    {
        return $this->codeDepartement;
    }

    public function setCodeDepartement(string $codeDepartement): self
    {
        $this->codeDepartement = $codeDepartement;
        return $this;
    }

    public function getLibDepartement(): string
    {
        return $this->libDepartement;
    }

    public function setLibDepartement(string $libDepartement): self
    {
        $this->libDepartement = $libDepartement;
        return $this;
    }

    public function getCodeCommercial(): ?string
    {
        return $this->codeCommercial;
    }

    public function setCodeCommercial(?string $codeCommercial): self
    {
        $this->codeCommercial = $codeCommercial;
        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;
        return $this;
    }

    public function getCommercial(): ?Commercial
    {
        return $this->commercial;
    }

    public function setCommercial(?Commercial $commercial): self
    {
        $this->commercial = $commercial;
        
        // Synchroniser automatiquement le code commercial
        if ($commercial) {
            $this->codeCommercial = $commercial->getCodeCommercial();
        } else {
            $this->codeCommercial = null;
        }
        
        return $this;
    }

    public function __toString(): string
    {
        return $this->codeDepartement . ' - ' . $this->libDepartement;
    }
}