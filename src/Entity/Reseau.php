<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "App\Repository\ReseauRepository")]
#[ORM\Table(name: "RESEAU")]
class Reseau
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "SEQRESEAU", type: "integer")]
    private ?int $seqreseau = null;

    #[ORM\Column(name: "NOMRESEAU", type: "string", length: 50, unique: true, options: ["default" => ""])]
    private string $nomreseau = '';

    #[ORM\Column(name: "DESACTIVE", type: "boolean", options: ["default" => false])]
    private bool $desactive = false;

    #[ORM\Column(name: "DATESAISIE", type: "datetime_immutable", options: ["default" => "CURRENT_TIMESTAMP"])]
    private \DateTimeImmutable $datesaisie;

    #[ORM\Column(name: "EMAIL_RESEAU", type: "string", length: 100, options: ["default" => ""])]
    private string $emailReseau = '';

    #[ORM\Column(name: "CODEORX", type: "string", length: 20, options: ["default" => ""])]
    private string $codeorx = '';

    // Relations
    #[ORM\ManyToOne(targetEntity: SuperReseau::class)]
    #[ORM\JoinColumn(name: "SEQSUPERRESEAU", referencedColumnName: "SEQSUPERRESEAU")]
    private ?SuperReseau $seqsuperreseau = null;

    #[ORM\ManyToOne(targetEntity: Typeregle::class)]
    #[ORM\JoinColumn(name: "SEQTYPEREGLE", referencedColumnName: "SEQTYPEREGLE")]
    private ?Typeregle $seqtyperegle = null;

    #[ORM\ManyToOne(targetEntity: TypeClt::class)]
    #[ORM\JoinColumn(name: "SEQTYPECLT", referencedColumnName: "SEQTYPECLT")]
    private ?TypeClt $seqtypeclt = null;

    #[ORM\ManyToOne(targetEntity: Commission::class)]
    #[ORM\JoinColumn(name: "SEQCOMM", referencedColumnName: "SEQCOMM")]
    private ?Commission $seqcomm = null;

    public function __construct()
    {
        $this->datesaisie = new \DateTimeImmutable();
    }

    public function getSeqreseau(): ?int
    {
        return $this->seqreseau;
    }

    public function getNOMRESEAU(): string
    {
        return $this->nomreseau;
    }

    public function setNOMRESEAU(string $nomreseau): self
    {
        $this->nomreseau = $nomreseau;
        return $this;
    }

    public function isDesactive(): bool
    {
        return $this->desactive;
    }

    public function setDesactive(bool $desactive): self
    {
        $this->desactive = $desactive;
        return $this;
    }

    public function getDatesaisie(): \DateTimeImmutable
    {
        return $this->datesaisie;
    }

    public function setDatesaisie(\DateTimeImmutable $datesaisie): self
    {
        $this->datesaisie = $datesaisie;
        return $this;
    }

    public function getEmailReseau(): string
    {
        return $this->emailReseau;
    }

    public function setEmailReseau(string $emailReseau): self
    {
        $this->emailReseau = $emailReseau;
        return $this;
    }

    public function getCodeorx(): string
    {
        return $this->codeorx;
    }

    public function setCodeorx(string $codeorx): self
    {
        $this->codeorx = $codeorx;
        return $this;
    }

    public function getSeqsuperreseau(): ?SuperReseau
    {
        return $this->seqsuperreseau;
    }

    public function setSeqsuperreseau(?SuperReseau $seqsuperreseau): self
    {
        $this->seqsuperreseau = $seqsuperreseau;
        return $this;
    }

    public function getSeqtyperegle(): ?Typeregle
    {
        return $this->seqtyperegle;
    }

    public function setSeqtyperegle(?Typeregle $seqtyperegle): self
    {
        $this->seqtyperegle = $seqtyperegle;
        return $this;
    }

    public function getSeqtypeclt(): ?TypeClt
    {
        return $this->seqtypeclt;
    }

    public function setSeqtypeclt(?TypeClt $seqtypeclt): self
    {
        $this->seqtypeclt = $seqtypeclt;
        return $this;
    }

    public function getSeqcomm(): ?Commission
    {
        return $this->seqcomm;
    }

    public function setSeqcomm(?Commission $seqcomm): self
    {
        $this->seqcomm = $seqcomm;
        return $this;
    }

    public function __toString(): string
    {
        return $this->nomreseau;
    }
}