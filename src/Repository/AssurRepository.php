<?php
namespace App\Repository;

use App\Entity\Assur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AssurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Assur::class);
    }

    // Tu peux ajouter des méthodes personnalisées ici si besoin
}
