<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: 'App\Repository\UtilisateurRepository')]
#[ORM\Table(name: 'UTILISATEUR')]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: 'integer', name: 'SEQUTIL')]
    private ?int $SEQUTIL = null;

    #[ORM\Column(type: 'datetime', name: 'MAJ')]
    private \DateTimeInterface $MAJ;

    #[ORM\Column(type: 'string', length: 6, name: 'CODEUTIL')]
    private string $CODEUTIL;

    #[ORM\Column(type: 'string', length: 30, name: 'NOMUTIL')]
    private string $NOMUTIL;

    #[ORM\Column(type: 'string', length: 25, name: 'PROFILUTIL')]
    private string $PROFILUTIL;

    #[ORM\Column(type: 'string', length: 255, name: 'MDP')]
    private string $MDP;

    #[ORM\Column(type: 'string', length: 4, name: 'BADGE')]
    private string $BADGE;

    #[ORM\Column(type: 'boolean', name: 'FLAG1')]
    private bool $FLAG1;

    #[ORM\Column(type: 'boolean', name: 'FLAG2')]
    private bool $FLAG2;

    #[ORM\Column(type: 'datetime', name: 'DATEDEB')]
    private \DateTimeInterface $DATEDEB;

    #[ORM\Column(type: 'datetime', name: 'HEURED')]
    private \DateTimeInterface $HEURED;

    #[ORM\Column(type: 'datetime', name: 'DATEFIN')]
    private \DateTimeInterface $DATEFIN;

    #[ORM\Column(type: 'datetime', name: 'HEUREF')]
    private \DateTimeInterface $HEUREF;

    #[ORM\Column(type: 'boolean', name: 'ENCOURS')]
    private bool $ENCOURS;

    #[ORM\Column(type: 'integer', name: 'SEQNIVEAU')]
    private int $SEQNIVEAU;

    #[ORM\Column(type: 'string', length: 50, name: 'emailutil')]
    private string $emailutil;

    #[ORM\Column(type: 'string', length: 10, name: 'WEBLOGIN')]
    private string $WEBLOGIN;

    #[ORM\Column(type: 'string', length: 100, name: 'WEBMDP')]
    private string $WEBMDP;
    public function __construct()
    {
        // Initialisation de la propriété MAJ avec la date actuelle par défaut
        $this->MAJ = new \DateTime();  // Valeur par défaut à la date et l'heure actuelles

        // Initialisation des propriétés qui doivent avoir des valeurs par défaut
        $this->CODEUTIL = ' ';
        $this->NOMUTIL = ' ';
        $this->PROFILUTIL = ' ';
        $this->MDP = ' ';
        $this->BADGE = ' ';
        $this->FLAG1 = false;
        $this->FLAG2 = false;
        $this->MAJ =    \DateTime::createFromFormat('d/m/Y', '01/01/1900');;
        $this->DATEDEB =\DateTime::createFromFormat('d/m/Y', '01/01/1900');;
        $this->HEURED = \DateTime::createFromFormat('d/m/Y', '01/01/1900');;
        $this->DATEFIN =\DateTime::createFromFormat('d/m/Y', '01/01/1900');;
        $this->HEUREF = \DateTime::createFromFormat('d/m/Y', '01/01/1900');;
        $this->ENCOURS = false;
        $this->SEQNIVEAU = 1;
        $this->emailutil = '';
        $this->WEBLOGIN = ' ';
        $this->WEBMDP = ' ';
    }

    public function getSEQUTIL(): ?int
    {
        return $this->SEQUTIL;
    }
    public function setSEQUTIL(?int $SEQUTIL): self
    {
        $this->SEQUTIL = $SEQUTIL;
        return $this;
    }
    public function getMAJ(): \DateTimeInterface
    {
        return $this->MAJ;
    }

    public function setMAJ(\DateTimeInterface $MAJ): self
    {
        $this->MAJ = $MAJ;
        return $this;
    }

    public function getCODEUTIL(): string
    {
        return $this->CODEUTIL;
    }

    public function setCODEUTIL(string $CODEUTIL): self
    {
        $this->CODEUTIL = $CODEUTIL;
        return $this;
    }

    public function getNOMUTIL(): string
    {
        return $this->NOMUTIL;
    }

    public function setNOMUTIL(string $NOMUTIL): self
    {
        $this->NOMUTIL = $NOMUTIL;
        return $this;
    }

    public function getPROFILUTIL(): string
    {
        return $this->PROFILUTIL;
    }

    public function setPROFILUTIL(string $PROFILUTIL): self
    {
        $this->PROFILUTIL = $PROFILUTIL;
        return $this;
    }

    public function getMDP(): string
    {
        return $this->MDP;
    }

    public function setMDP(string $MDP): self
    {
        $this->MDP = $MDP;
        return $this;
    }

    public function getBADGE(): string
    {
        return $this->BADGE;
    }

    public function setBADGE(string $BADGE): self
    {
        $this->BADGE = $BADGE;
        return $this;
    }

    public function isFLAG1(): bool
    {
        return $this->FLAG1;
    }

    public function setFLAG1(bool $FLAG1): self
    {
        $this->FLAG1 = $FLAG1;
        return $this;
    }

    public function isFLAG2(): bool
    {
        return $this->FLAG2;
    }

    public function setFLAG2(bool $FLAG2): self
    {
        $this->FLAG2 = $FLAG2;
        return $this;
    }

    public function getDATEDEB(): \DateTimeInterface
    {
        return $this->DATEDEB;
    }

    public function setDATEDEB(\DateTimeInterface $DATEDEB): self
    {
        $this->DATEDEB = $DATEDEB;
        return $this;
    }

    public function getHEURED(): \DateTimeInterface
    {
        return $this->HEURED;
    }

    public function setHEURED(\DateTimeInterface $HEURED): self
    {
        $this->HEURED = $HEURED;
        return $this;
    }

    public function getDATEFIN(): \DateTimeInterface
    {
        return $this->DATEFIN;
    }

    public function setDATEFIN(\DateTimeInterface $DATEFIN): self
    {
        $this->DATEFIN = $DATEFIN;
        return $this;
    }

    public function getHEUREF(): \DateTimeInterface
    {
        return $this->HEUREF;
    }

    public function setHEUREF(\DateTimeInterface $HEUREF): self
    {
        $this->HEUREF = $HEUREF;
        return $this;
    }

    public function isENCOURS(): bool
    {
        return $this->ENCOURS;
    }

    public function setENCOURS(bool $ENCOURS): self
    {
        $this->ENCOURS = $ENCOURS;
        return $this;
    }

    public function getSEQNIVEAU(): int
    {
        return $this->SEQNIVEAU;
    }

    public function setSEQNIVEAU(int $SEQNIVEAU): self
    {
        $this->SEQNIVEAU = $SEQNIVEAU;
        return $this;
    }

    public function getEmailutil(): string
    {
        return $this->emailutil;
    }

    public function setEmailutil(string $emailutil): self
    {
        $this->emailutil = $emailutil;
        return $this;
    }

    public function getWEBLOGIN(): string
    {
        return $this->WEBLOGIN;
    }

    public function setWEBLOGIN(string $WEBLOGIN): self
    {
        $this->WEBLOGIN = $WEBLOGIN;
        return $this;
    }

    public function getWEBMDP(): string
    {
        return $this->WEBMDP;
    }

    public function setWEBMDP(string $WEBMDP): self
    {
        $this->WEBMDP = $WEBMDP;
        return $this;
    }
//    #[ORM\Column(type: 'string', name: 'roles')]
//    private string $roles = 'ROLE_USER';
    // Required methods from UserInterface
//    public function getUserIdentifier(): string
//    {
//        return $this->CODEUTIL;
//    }

    public function getRoles(): array
    {
        $roles = [];

        if ($this->PROFILUTIL === 'ADMIN') {
            $roles[] = 'ROLE_ADMIN';
        } elseif ($this->PROFILUTIL === 'USER') {
            $roles[] = 'ROLE_USER';
        } else {
            $roles[] = 'ROLE_USER'; // rôle par défaut
        }

        return array_unique($roles);
    }


    // Required methods from PasswordAuthenticatedUserInterface
//

    public function eraseCredentials(): void
    {
        // Clear any sensitive data
    }
    public function getUserIdentifier(): string
    {
        return $this->CODEUTIL; // Utiliser NOMUTIL comme identifiant
    }

    public function getPassword(): string
    {
        return $this->MDP;
    }

}
