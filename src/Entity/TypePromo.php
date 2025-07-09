<?php

namespace App\Entity;

use App\Repository\TypePromoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TypePromoRepository::class)]
#[ORM\Table(name: 'TYPE_PROMO')]
#[UniqueEntity('libTypePromo', message: 'Ce libellé existe déjà.')]
class TypePromo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'SEQ_TYPE_PROMO', type: 'integer')]
    private ?int $seqTypePromo = null;

    #[ORM\Column(name: 'LIB_TYPE_PROMO', type: 'string', length: 50, unique: true)]
    #[Assert\NotBlank(message: 'Le libellé est requis.')]
    #[Assert\Length(max: 50, maxMessage: 'Le libellé ne peut pas dépasser 50 caractères.')]
    private ?string $libTypePromo = null;

    public function getSeqTypePromo(): ?int
    {
        return $this->seqTypePromo;
    }

    public function getLibTypePromo(): ?string
    {
        return $this->libTypePromo;
    }

    public function setLibTypePromo(string $libTypePromo): static
    {
        $this->libTypePromo = $libTypePromo;

        return $this;
    }

    public function __toString(): string
    {
        return $this->libTypePromo ?? '';
    }
}
