<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "TYPEOPTION",
    uniqueConstraints: [
        new ORM\UniqueConstraint(name: "uniq_codeoption", columns: ["CODEOPTION"]),
        new ORM\UniqueConstraint(name: "uniq_nomoption", columns: ["NOMOPTION"])
    ]
)]
class TypeOption
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "SEQTYPEOPTION", type: "integer")]
    private ?int $seqTypeOption = null;

    #[ORM\Column(name: "CODEOPTION", type: "string", length: 1, unique: true)]
    private string $codeOption = '';

    #[ORM\Column(name: "NOMOPTION", type: "string", length: 20)]
    private string $nomOption = '';

    #[ORM\Column(name: "AUTORISER", type: "boolean", options: ["default" => false])]
    private bool $autoriser = false;

    #[ORM\Column(name: "ORDRE", type: "boolean", options: ["default" => false])]
    private bool $ordre = false;

    // Getters et setters

    public function getSeqTypeOption(): ?int
    {
        return $this->seqTypeOption;
    }

    public function getCodeOption(): string
    {
        return $this->codeOption;
    }

    public function setCodeOption(string $codeOption): self
    {
        $this->codeOption = $codeOption;
        return $this;
    }

    public function getNomOption(): string
    {
        return $this->nomOption;
    }

    public function setNomOption(string $nomOption): self
    {
        $this->nomOption = $nomOption;
        return $this;
    }

    public function isAutoriser(): bool
    {
        return $this->autoriser;
    }

    public function setAutoriser(bool $autoriser): self
    {
        $this->autoriser = $autoriser;
        return $this;
    }

    public function isOrdre(): bool
    {
        return $this->ordre;
    }

    public function setOrdre(bool $ordre): self
    {
        $this->ordre = $ordre;
        return $this;
    }
}
