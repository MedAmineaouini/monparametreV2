<?php
namespace App\Repository;

use App\Entity\Affreteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AffreteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Affreteur::class);
    }

    // Tu peux ajouter des méthodes personnalisées ici si besoin
}
