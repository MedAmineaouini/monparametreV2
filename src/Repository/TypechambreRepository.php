<?php
namespace App\Repository;

use App\Entity\Typechambre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TypechambreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Typechambre::class);
    }

    // Tu peux ajouter des méthodes personnalisées ici si besoin
}
