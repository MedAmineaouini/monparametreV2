<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "COMMERCIAL")]
class Commercial
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "SEQCOMMERCIAL", type: "integer")]
    private int $seqCommercial;

    #[ORM\Column(name: "CODECOMMERCIAL", type: "string", length: 4)]
    private string $codeCommercial;

    #[ORM\Column(name: "NOMCOMMERCIAL", type: "string", length: 30)]
    private string $nomCommercial;

    #[ORM\Column(name: "PRENOMCOMMERCIAL", type: "string", length: 25)]
    private string $prenomCommercial;

    #[ORM\Column(name: "TELCOMMERCIAL", type: "string", length: 20)]
    private string $telCommercial;

    public function __construct()
    {
        $this->codeCommercial = '';
        $this->nomCommercial = '';
        $this->prenomCommercial = '';
        $this->telCommercial = '';
        $this->seqCommercial = 0; 
    }

    // Getters et Setters...

    public function getSeqCommercial(): int
    {
        return $this->seqCommercial;
    }

    public function getCodeCommercial(): string
    {
        return $this->codeCommercial;
    }

    public function setCodeCommercial(string $code): self
    {
        $this->codeCommercial = $code;
        return $this;
    }

    public function getNomCommercial(): string
    {
        return $this->nomCommercial;
    }

    public function setNomCommercial(string $nom): self
    {
        $this->nomCommercial = $nom;
        return $this;
    }

    public function getPrenomCommercial(): string
    {
        return $this->prenomCommercial;
    }

    public function setPrenomCommercial(string $prenom): self
    {
        $this->prenomCommercial = $prenom;
        return $this;
    }

    public function getTelCommercial(): string
    {
        return $this->telCommercial;
    }

    public function setTelCommercial(string $tel): self
    {
        $this->telCommercial = $tel;
        return $this;
    }
}