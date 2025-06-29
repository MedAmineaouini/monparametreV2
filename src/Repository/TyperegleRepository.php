<?php
namespace App\Repository;

use App\Entity\Typeregle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TyperegleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Typeregle::class);
    }

    // Tu peux ajouter des méthodes personnalisées ici si besoin
}
