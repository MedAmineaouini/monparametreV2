<?php

namespace App\Entity;

use App\Repository\SousReseauRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SousReseauRepository::class)]
#[ORM\Table(name: 'SOUSRESEAU')]
#[UniqueEntity(fields: ['nomsousreseau'], message: 'Ce nom de sous-réseau existe déjà')]
class SousReseau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'SEQSOUSRESEAU', type: 'integer')]
    private ?int $seqsousreseau = null;

    #[ORM\Column(name: 'NOMSOUSRESEAU', length: 50, unique: true)]
    #[Assert\NotBlank(message: 'Le nom du sous-réseau est obligatoire')]
    #[Assert\Length(
        max: 50,
        maxMessage: 'Le nom ne doit pas dépasser {{ limit }} caractères'
    )]
    private ?string $nomsousreseau = null;

    public function getSeqsousreseau(): ?int
    {
        return $this->seqsousreseau;
    }

    public function getNomsousreseau(): ?string
    {
        return $this->nomsousreseau;
    }

    public function setNomsousreseau(string $nomsousreseau): static
    {
        $this->nomsousreseau = $nomsousreseau;

        return $this;
    }

    public function __toString(): string
    {
        return $this->nomsousreseau ?? '';
    }
}