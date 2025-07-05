<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "PENSIONORCHESTRA",
    uniqueConstraints: [
        new ORM\UniqueConstraint(name: "uniq_libpensionorchestra", columns: ["LIBPENSIONORCHESTRA"])
    ]
)]
class PensionOrchestra
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "SEQPENSIONORCHESTRA", type: "integer")]
    private ?int $seqPensionOrchestra = null;

    #[ORM\Column(name: "LIBPENSIONORCHESTRA", type: "string", length: 50, options: ["default" => ""])]
    private string $libPensionOrchestra = '';

    // Getters et Setters

    public function getSeqPensionOrchestra(): ?int
    {
        return $this->seqPensionOrchestra;
    }

    public function getLibPensionOrchestra(): string
    {
        return $this->libPensionOrchestra;
    }

    public function setLibPensionOrchestra(string $libPensionOrchestra): self
    {
        $this->libPensionOrchestra = $libPensionOrchestra;
        return $this;
    }
}
