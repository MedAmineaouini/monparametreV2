<?php
// src/Entity/SousReseau.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: 'App\Repository\SousReseauRepository')]
#[ORM\Table(name: 'SOUSRESEAU')]
#[ORM\UniqueConstraint(name: 'IX_SOUSRESEAU', columns: ['NOMSOUSRESEAU'])]
class SousReseau
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'SEQSOUSRESEAU', type: 'integer')]
    private ?int $seqsousreseau = null;

    #[ORM\Column(name: 'NOMSOUSRESEAU', type: 'string', length: 50, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 50)]
    private string $nomSousReseau;

    /**
     * @return int|null
     */
    public function getSeqsousreseau(): ?int
    {
        return $this->seqsousreseau;
    }

    /**
     * @param int|null $seqsousreseau
     */
    public function setSeqsousreseau(?int $seqsousreseau): void
    {
        $this->seqsousreseau = $seqsousreseau;
    }

    // Getters et setters
//    public function getId(): ?int
//    {
//        return $this->id;
//    }

    public function getNomSousReseau(): string
    {
        return $this->nomSousReseau;
    }

    public function setNomSousReseau(string $nomSousReseau): self
    {
        $this->nomSousReseau = $nomSousReseau;
        return $this;
    }
}