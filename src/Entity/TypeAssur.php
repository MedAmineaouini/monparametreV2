<?php

namespace App\Entity;

use App\Repository\TypeAssurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeAssurRepository::class)]
#[ORM\Table(name: 'TYPEASSUR')]
class TypeAssur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'SEQTYPEASSUR', type: 'integer')]
    private ?int $seqtypeassur = null;

    #[ORM\Column(name: 'LIBTYPEASSUR', type: 'string', length: 30)]
    private ?string $libTypeAssur = null;

    // ✅ Constructeur avec valeur par défaut
    public function __construct(string $defaultLib = 'Non défini')
    {
        $this->libTypeAssur = $defaultLib;
    }

    public function getSeqTypeAssur(): ?int
    {
        return $this->seqtypeassur;
    }

    public function getLibTypeAssur(): ?string
    {
        return $this->libTypeAssur;
    }

    public function setLibTypeAssur(string $libTypeAssur): self
    {
        $this->libTypeAssur = $libTypeAssur;
        return $this;
    }

    public function __toString(): string
    {
        return $this->libTypeAssur ?? '';
    }
}
