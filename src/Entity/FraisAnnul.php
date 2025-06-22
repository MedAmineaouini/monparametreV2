<?php

namespace App\Entity;

use App\Repository\FraisAnnulRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FraisAnnulRepository::class)]
class FraisAnnul
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
