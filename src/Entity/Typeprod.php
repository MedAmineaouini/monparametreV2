<?php

namespace App\Entity;

use App\Repository\TypeprodRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeprodRepository::class)]
#[ORM\Table(name: "TYPEPROD")]
class Typeprod
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "SEQTYPEPROD", type: "integer")]
    private ?int $SEQTYPEPROD = null;

    #[ORM\Column(name: "LIBTYPEPROD", type: "string", length: 20, nullable: true)]
    private ?string $LIBTYPEPROD = null;

    public function __construct()
    {
        $this->LIBTYPEPROD = '';
    }

    // === GETTERS & SETTERS ===

    public function getSEQTYPEPROD(): ?int
    {
        return $this->SEQTYPEPROD;
    }

    public function getLIBTYPEPROD(): ?string
    {
        return $this->LIBTYPEPROD;
    }

    public function setLIBTYPEPROD(?string $LIBTYPEPROD): self
    {
        $this->LIBTYPEPROD = $LIBTYPEPROD ?? '';
        return $this;
    }
}
