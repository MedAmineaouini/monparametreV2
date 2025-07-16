<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'AFFRETEUR')]
class Affreteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'SEQAFFRET', type: 'integer')]
    private ?int $seqaffret = null;

    #[ORM\Column(name: 'CODAFFRET', type: 'string', length: 3, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 3)]
    private string $codaffret = '';

    #[ORM\Column(name: 'LIBAFFRET', type: 'string', length: 40)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 40)]
    private string $libaffret = '';

    #[ORM\Column(name: 'Compagnie', type: 'integer')]
    private int $compagnie = 0;

    // Getters and Setters

    public function getSeqaffret(): ?int
    {
        return $this->seqaffret;
    }

    public function getCodaffret(): string
    {
        return $this->codaffret;
    }

    public function setCodaffret(string $codaffret): self
    {
        $this->codaffret = $codaffret;
        return $this;
    }

    public function getLibaffret(): string
    {
        return $this->libaffret;
    }

    public function setLibaffret(string $libaffret): self
    {
        $this->libaffret = $libaffret;
        return $this;
    }

    public function getCompagnie(): int
    {
        return $this->compagnie;
    }

    public function setCompagnie(int $compagnie): self
    {
        $this->compagnie = $compagnie;
        return $this;
    }
}