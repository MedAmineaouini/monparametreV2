<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: 'App\Repository\SuperReseauRepository')]
#[ORM\Table(name: 'SUPER_RESEAU')]
class SuperReseau
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'SEQSUPERRESEAU', type: 'integer')]
    private ?int $seqsuperreseau = null;

    #[ORM\Column(name: 'NOMSUPERRESEAU', type: 'string', length: 50, unique: true, nullable: false, options: ['default' => ''])]
    #[Assert\NotBlank(message: "Le nom du super réseau est obligatoire")]
    #[Assert\Length(
        max: 50,
        maxMessage: "Le nom ne doit pas dépasser {{ limit }} caractères"
    )]
    private string $nomsuperreseau = '';

    #[ORM\Column(name: 'DATESAISIE', type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private \DateTimeInterface $datesaisie;

    public function __construct()
    {
        $this->datesaisie = new \DateTime(); // Double sécurité
    }

    /**
     * @return int|null
     */
    public function getSeqsuperreseau(): ?int
    {
        return $this->seqsuperreseau;
    }

    /**
     * @param int|null $seqsuperreseau
     */
    public function setSeqsuperreseau(?int $seqsuperreseau): void
    {
        $this->seqsuperreseau = $seqsuperreseau;
    }

    /**
     * @return string
     */
    public function getNomsuperreseau(): string
    {
        return $this->nomsuperreseau;
    }

    /**
     * @param string $nomsuperreseau
     */
    public function setNomsuperreseau(string $nomsuperreseau): void
    {
        $this->nomsuperreseau = $nomsuperreseau;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDatesaisie(): \DateTimeInterface
    {
        return $this->datesaisie;
    }

    /**
     * @param \DateTimeInterface $datesaisie
     */
    public function setDatesaisie(\DateTimeInterface $datesaisie): void
    {
        $this->datesaisie = $datesaisie;
    }

    // ... (getters and setters)
    public function __toString(): string
    {
        return $this->nomsuperreseau;
    }

}