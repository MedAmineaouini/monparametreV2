<?php
namespace App\Repository;

use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UtilisateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateur::class);
    }
    public function loadUserByIdentifier(string $identifier): ?\Symfony\Component\Security\Core\User\UserInterface
    {
        return $this->findOneBy(['NOMUTIL' => $identifier]);
    }

    // Ajoute des méthodes spécifiques pour ton repository ici
}
