<?php

namespace App\Entity;

use App\Repository\NiveauRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[ORM\Table(name: 'NIVEAU')]
#[ORM\Entity(repositoryClass: NiveauRepository::class)]
#[UniqueEntity(
    fields: ['libniveau'],
    message: 'Ce libellé de niveau est déjà utilisé.'
)]
class Niveau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'SEQNIVEAU')]
    private ?int $id = null;

    #[ORM\Column(name: 'LIBNIVEAU', length: 30, unique: true)]
    private ?string $libniveau = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibniveau(): ?string
    {
        return $this->libniveau;
    }

    public function setLibniveau(string $libniveau): self
    {
        $this->libniveau = $libniveau;

        return $this;
    }

    public function __toString(): string
    {
        return $this->libniveau ?? '';
    }
}
