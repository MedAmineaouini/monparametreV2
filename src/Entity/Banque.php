<?php

namespace App\Entity;

use App\Repository\BanqueRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: "BANQUE")]
#[UniqueEntity('LIBBANQUE', message: 'Cette banque existe déjà')]
#[UniqueEntity('CPTBANQUE', message: 'Ce compte bancaire existe déjà')]
#[UniqueEntity('numterminal', message: 'Ce numéro de terminal existe déjà')]
class Banque
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'SEQBANQUE', type: 'integer')]
    private ?int $SEQBANQUE = null;

    #[ORM\Column(name: 'LIBBANQUE', type: 'string', length: 30, unique: true)]
    #[Assert\NotBlank(message: 'Le nom de la banque est obligatoire')]
    #[Assert\Length(max: 30, maxMessage: 'Le nom ne doit pas dépasser 30 caractères')]
    private string $LIBBANQUE = '';

    #[ORM\Column(name: 'CPTBANQUE', type: 'string', length: 30, unique: true)]
    #[Assert\NotBlank(message: 'Le compte bancaire est obligatoire')]
    private string $CPTBANQUE = '';

    #[ORM\Column(name: 'SWFBANQUE', type: 'string', length: 30)]
    #[Assert\NotBlank(message: 'Le code SWIFT est obligatoire')]
    private string $SWFBANQUE = '';

    #[ORM\Column(name: 'ADRBANQUE', type: 'string', length: 30)]
    #[Assert\NotBlank(message: "L'adresse est obligatoire")]
    private string $ADRBANQUE = '';

    #[ORM\Column(name: 'CPBANQUE', type: 'string', length: 8)]
    #[Assert\NotBlank(message: 'Le code postal est obligatoire')]
    private string $CPBANQUE = '';

    #[ORM\ManyToOne(targetEntity: Ville::class)]
    #[ORM\JoinColumn(name: 'VILBANQUE', referencedColumnName: 'SEQVILLE', nullable: false)]
    private ?Ville $VILBANQUE = null;
  
    #[ORM\ManyToOne(targetEntity: Pays::class)]
    #[ORM\JoinColumn(name: 'PAYBANQUE', referencedColumnName: 'IDPAYS', nullable: false)]
    private ?Pays $PAYBANQUE = null;

    #[ORM\Column(name: 'TELBANQUE', type: 'string', length: 30)]
    #[Assert\NotBlank(message: 'Le téléphone est obligatoire')]
    private string $TELBANQUE = '';

    #[ORM\Column(name: 'FAXBANQUE', type: 'string', length: 30, nullable: true)]
    private ?string $FAXBANQUE = null;

    #[ORM\Column(name: 'EMLBANQUE', type: 'string', length: 50, nullable: true)]
    #[Assert\Email(message: "L'email n'est pas valide")]
    private ?string $EMLBANQUE = null;

    #[ORM\Column(name: 'OBSBANQUE', type: 'text', nullable: true)]
    private ?string $OBSBANQUE = null;

    #[ORM\Column(name: 'numterminal', type: 'string', length: 5, unique: true)]
    #[Assert\Length(
        min: 5,
        max: 5,
        minMessage: 'Le numéro terminal doit faire exactement 5 caractères',
        maxMessage: 'Le numéro terminal doit faire exactement 5 caractères'
    )]
    private string $numterminal = '00000';

    #[ORM\Column(name: 'Journal1', type: 'string', length: 10, nullable: true)]
    private ?string $Journal1 = null;

    #[ORM\Column(name: 'Journal2', type: 'string', length: 10, nullable: true)]
    private ?string $Journal2 = null;

    #[ORM\Column(name: 'compte1', type: 'string', length: 15, nullable: true)]
    private ?string $compte1 = null;

    #[ORM\Column(name: 'compte2', type: 'string', length: 15, nullable: true)]
    private ?string $compte2 = null;

    public function __construct()
    {
        $this->numterminal = '00000';
    }

    public function getSEQBANQUE(): ?int
    {
        return $this->SEQBANQUE;
    }

    public function getLIBBANQUE(): string
    {
        return $this->LIBBANQUE;
    }

    public function setLIBBANQUE(string $LIBBANQUE): self
    {
        $this->LIBBANQUE = $LIBBANQUE;
        return $this;
    }

    public function getCPTBANQUE(): string
    {
        return $this->CPTBANQUE;
    }

    public function setCPTBANQUE(string $CPTBANQUE): self
    {
        $this->CPTBANQUE = $CPTBANQUE;
        return $this;
    }

    public function getSWFBANQUE(): string
    {
        return $this->SWFBANQUE;
    }

    public function setSWFBANQUE(string $SWFBANQUE): self
    {
        $this->SWFBANQUE = $SWFBANQUE;
        return $this;
    }

    public function getADRBANQUE(): string
    {
        return $this->ADRBANQUE;
    }

    public function setADRBANQUE(string $ADRBANQUE): self
    {
        $this->ADRBANQUE = $ADRBANQUE;
        return $this;
    }

    public function getCPBANQUE(): string
    {
        return $this->CPBANQUE;
    }

    public function setCPBANQUE(string $CPBANQUE): self
    {
        $this->CPBANQUE = $CPBANQUE;
        return $this;
    }

    public function getVILBANQUE(): ?Ville
    {
        return $this->VILBANQUE;
    }

    public function setVILBANQUE(?Ville $VILBANQUE): self
    {
        $this->VILBANQUE = $VILBANQUE;
        return $this;
    }

    public function getPAYBANQUE(): ?Pays
    {
        return $this->PAYBANQUE;
    }

    public function setPAYBANQUE(?Pays $PAYBANQUE): self
    {
        $this->PAYBANQUE = $PAYBANQUE;
        return $this;
    }

    public function getTELBANQUE(): string
    {
        return $this->TELBANQUE;
    }

    public function setTELBANQUE(string $TELBANQUE): self
    {
        $this->TELBANQUE = $TELBANQUE;
        return $this;
    }

    public function getFAXBANQUE(): ?string
    {
        return $this->FAXBANQUE;
    }

    public function setFAXBANQUE(?string $FAXBANQUE): self
    {
        $this->FAXBANQUE = $FAXBANQUE;
        return $this;
    }

    public function getEMLBANQUE(): ?string
    {
        return $this->EMLBANQUE;
    }

    public function setEMLBANQUE(?string $EMLBANQUE): self
    {
        $this->EMLBANQUE = $EMLBANQUE;
        return $this;
    }

    public function getOBSBANQUE(): ?string
    {
        return $this->OBSBANQUE;
    }

    public function setOBSBANQUE(?string $OBSBANQUE): self
    {
        $this->OBSBANQUE = $OBSBANQUE;
        return $this;
    }

    public function getNumterminal(): string
    {
        return $this->numterminal;
    }

    public function setNumterminal(string $numterminal): self
    {
        $this->numterminal = $numterminal;
        return $this;
    }

    public function getJournal1(): ?string
    {
        return $this->Journal1;
    }

    public function setJournal1(?string $Journal1): self
    {
        $this->Journal1 = $Journal1;
        return $this;
    }

    public function getJournal2(): ?string
    {
        return $this->Journal2;
    }

    public function setJournal2(?string $Journal2): self
    {
        $this->Journal2 = $Journal2;
        return $this;
    }

    public function getCompte1(): ?string
    {
        return $this->compte1;
    }

    public function setCompte1(?string $compte1): self
    {
        $this->compte1 = $compte1;
        return $this;
    }

    public function getCompte2(): ?string
    {
        return $this->compte2;
    }

    public function setCompte2(?string $compte2): self
    {
        $this->compte2 = $compte2;
        return $this;
    }

    public function __toString(): string
    {
        return $this->LIBBANQUE;
    }
}
