<?php
// src/Entity/Receptif.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "App\Repository\ReceptifRepository")]
#[ORM\Table(name: "RECEPTIF")]
class Receptif
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'SEQRECEPTIF', type: 'integer')]
    private int $seqReceptif;

    #[ORM\Column(name: 'NOMRECEPTIF', type: 'string', length: 60)]
    private string $nomReceptif = '';

    #[ORM\Column(name: 'ADRESSE', type: 'string', length: 80)]
    private string $adresse = '';

    #[ORM\Column(name: 'CP', type: 'string', length: 6)]
    private string $cp = '';

    #[ORM\ManyToOne(targetEntity: 'App\Entity\Ville')]
    #[ORM\JoinColumn(name: 'SEQVILLE', referencedColumnName: 'SEQVILLE')]
    private ?Ville $ville = null;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\Pays')]
    #[ORM\JoinColumn(name: 'IDPAYS', referencedColumnName: 'IDPAYS')]
    private ?Pays $pays = null;

    #[ORM\Column(name: 'TEL1', type: 'string', length: 60)]
    private string $tel1 = '';

    #[ORM\Column(name: 'TEL2', type: 'string', length: 60)]
    private string $tel2 = '';

    #[ORM\Column(name: 'FAX', type: 'string', length: 20)]
    private string $fax = '';

    #[ORM\Column(name: 'EMAIL', type: 'string', length: 80)]
    private string $email = '';

    #[ORM\Column(name: 'CONTACT1', type: 'string', length: 30)]
    private string $contact1 = '';

    #[ORM\Column(name: 'CONTACT2', type: 'string', length: 30)]
    private string $contact2 = '';

    #[ORM\Column(name: 'OBS', type: 'text')]
    private string $obs = '';

    #[ORM\Column(name: 'IDRECEPTIF', type: 'string', length: 10)]
    private string $idReceptif = '';

    #[ORM\Column(name: 'MDPRECEPTIF', type: 'string', length: 10)]
    private string $mdpReceptif = '';

    #[ORM\Column(name: 'ESCALE1', type: 'string', length: 3)]
    private string $escale1 = '';

    #[ORM\Column(name: 'ESCALE2', type: 'string', length: 3)]
    private string $escale2 = '';

    #[ORM\Column(name: 'ESCALE3', type: 'string', length: 3)]
    private string $escale3 = '';

    #[ORM\Column(name: 'ESCALE4', type: 'string', length: 3)]
    private string $escale4 = '';

    #[ORM\Column(name: 'ARCHIVER', type: 'integer')]
    private int $archiver = 0;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\Souspays')]
    #[ORM\JoinColumn(name: 'SEQSOUSPAYS', referencedColumnName: 'SEQSOUSPAYS')]
    private ?SousPays $sousPays = null;

    #[ORM\Column(name: 'RESTRICTION_HOTEL', type: 'integer')]
    private int $restrictionHotel = 1;

    #[ORM\Column(name: 'HOTEL1', type: 'string', length: 4)]
    private string $hotel1 = '';

    #[ORM\Column(name: 'HOTEL2', type: 'string', length: 4)]
    private string $hotel2 = '';

    // Getters and setters
    public function getSeqReceptif(): int
    {
        return $this->seqReceptif;
    }

    public function getNomReceptif(): string
    {
        return $this->nomReceptif;
    }

    public function setNomReceptif(string $nomReceptif): self
    {
        $this->nomReceptif = $nomReceptif;
        return $this;
    }

    public function getAdresse(): string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;
        return $this;
    }

    public function getCp(): string
    {
        return $this->cp;
    }

    public function setCp(string $cp): self
    {
        $this->cp = $cp;
        return $this;
    }

    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    public function setVille(?Ville $ville): self
    {
        $this->ville = $ville;
        return $this;
    }

    public function getPays(): ?Pays
    {
        return $this->pays;
    }

    public function setPays(?Pays $pays): self
    {
        $this->pays = $pays;
        return $this;
    }



    public function getTel1(): string
    {
        return $this->tel1;
    }

    public function setTel1(string $tel1): self
    {
        $this->tel1 = $tel1;
        return $this;
    }

    public function getTel2(): string
    {
        return $this->tel2;
    }

    public function setTel2(string $tel2): self
    {
        $this->tel2 = $tel2;
        return $this;
    }

    public function getFax(): string
    {
        return $this->fax;
    }

    public function setFax(string $fax): self
    {
        $this->fax = $fax;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getContact1(): string
    {
        return $this->contact1;
    }

    public function setContact1(string $contact1): self
    {
        $this->contact1 = $contact1;
        return $this;
    }

    public function getContact2(): string
    {
        return $this->contact2;
    }

    public function setContact2(string $contact2): self
    {
        $this->contact2 = $contact2;
        return $this;
    }

    public function getObs(): string
    {
        return $this->obs;
    }

    public function setObs(string $obs): self
    {
        $this->obs = $obs;
        return $this;
    }

    public function getIdReceptif(): string
    {
        return $this->idReceptif;
    }

    public function setIdReceptif(string $idReceptif): self
    {
        $this->idReceptif = $idReceptif;
        return $this;
    }

    public function getMdpReceptif(): string
    {
        return $this->mdpReceptif;
    }

    public function setMdpReceptif(string $mdpReceptif): self
    {
        $this->mdpReceptif = $mdpReceptif;
        return $this;
    }

    public function getEscale1(): string
    {
        return $this->escale1;
    }

    public function setEscale1(string $escale1): self
    {
        $this->escale1 = $escale1;
        return $this;
    }

    public function getEscale2(): string
    {
        return $this->escale2;
    }

    public function setEscale2(string $escale2): self
    {
        $this->escale2 = $escale2;
        return $this;
    }

    public function getEscale3(): string
    {
        return $this->escale3;
    }

    public function setEscale3(string $escale3): self
    {
        $this->escale3 = $escale3;
        return $this;
    }

    public function getEscale4(): string
    {
        return $this->escale4;
    }

    public function setEscale4(string $escale4): self
    {
        $this->escale4 = $escale4;
        return $this;
    }

    public function getArchiver(): int
    {
        return $this->archiver;
    }

    public function setArchiver(int $archiver): self
    {
        $this->archiver = $archiver;
        return $this;
    }

    public function getSousPays(): ?SousPays
    {
        return $this->sousPays;
    }

    public function setSousPays(?SousPays $sousPays): self
    {
        $this->sousPays = $sousPays;
        return $this;
    }

    public function getRestrictionHotel(): int
    {
        return $this->restrictionHotel;
    }

    public function setRestrictionHotel(int $restrictionHotel): self
    {
        $this->restrictionHotel = $restrictionHotel;
        return $this;
    }

    public function getHotel1(): string
    {
        return $this->hotel1;
    }

    public function setHotel1(string $hotel1): self
    {
        $this->hotel1 = $hotel1;
        return $this;
    }

    public function getHotel2(): string
    {
        return $this->hotel2;
    }

    public function setHotel2(string $hotel2): self
    {
        $this->hotel2 = $hotel2;
        return $this;
    }
}