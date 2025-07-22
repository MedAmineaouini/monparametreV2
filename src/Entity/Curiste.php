<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Souspays;
use App\Entity\Pays;

#[ORM\Entity]
#[ORM\Table(name: 'CURISTE')]
#[ORM\UniqueConstraint(name: 'IX_CURISTE', columns: ['CODECURISTE'])]
class Curiste
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'SEQCURISTE', type: Types::INTEGER)]
    private ?int $seqCuriste = null;

    #[ORM\Column(name: 'CODECURISTE', type: Types::STRING, length: 5, unique: true)]
    private string $codeCuriste;

    #[ORM\Column(name: 'NOMCURISTE', type: Types::STRING, length: 30)]
    private string $nomCuriste;

    #[ORM\Column(name: 'ADRESSE', type: Types::STRING, length: 100)]
    private string $adresse;

    #[ORM\Column(name: 'CP', type: Types::STRING, length: 7)]
    private string $cp;

    #[ORM\Column(name: 'LIBVILLE', type: Types::STRING, length: 20)]
    private string $libVille;

    #[ORM\Column(name: 'TEL1', type: Types::STRING, length: 30)]
    private string $tel1;

    #[ORM\Column(name: 'TEL2', type: Types::STRING, length: 30)]
    private string $tel2;

    #[ORM\Column(name: 'FAX', type: Types::STRING, length: 30)]
    private string $fax;

    #[ORM\Column(name: 'EMAIL', type: Types::STRING, length: 80)]
    private string $email;

    #[ORM\Column(name: 'CONTACT1', type: Types::STRING, length: 30)]
    private string $contact1;

    #[ORM\Column(name: 'CONTACT2', type: Types::STRING, length: 30)]
    private string $contact2;

    #[ORM\Column(name: 'OBS', type: Types::TEXT)]
    private string $obs;

    #[ORM\Column(name: 'MARGE', type: Types::INTEGER)]
    private int $marge;

    #[ORM\ManyToOne(targetEntity: Souspays::class)]
    #[ORM\JoinColumn(name: 'SEQSOUSPAYS', referencedColumnName: 'SEQSOUSPAYS')]
    private ?SousPays $sousPays = null;

    #[ORM\ManyToOne(targetEntity: Pays::class)]
    #[ORM\JoinColumn(name: 'IDPAYS', referencedColumnName: 'IDPAYS')]
    private ?Pays $pays = null;

    // Getters and setters...
    public function getSeqCuriste(): ?int
    {
        return $this->seqCuriste;
    }

    public function getCodeCuriste(): string
    {
        return $this->codeCuriste;
    }

    public function setCodeCuriste(string $codeCuriste): self
    {
        $this->codeCuriste = $codeCuriste;
        return $this;
    }

    public function getNomCuriste(): string
    {
        return $this->nomCuriste;
    }

    public function setNomCuriste(string $nomCuriste): self
    {
        $this->nomCuriste = $nomCuriste;
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

    public function getLibVille(): string
    {
        return $this->libVille;
    }

    public function setLibVille(string $libVille): self
    {
        $this->libVille = $libVille;
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

    public function getMarge(): int
    {
        return $this->marge;
    }

    public function setMarge(int $marge): self
    {
        $this->marge = $marge;
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

    public function getPays(): ?Pays
    {
        return $this->pays;
    }

    public function setPays(?Pays $pays): self
    {
        $this->pays = $pays;
        return $this;
    }
}