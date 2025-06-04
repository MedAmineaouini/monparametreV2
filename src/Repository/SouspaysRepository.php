<?php

namespace App\Repository;

use App\Entity\Souspays;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Souspays>
 *
 * @method Souspays|null find($id, $lockMode = null, $lockVersion = null)
 * @method Souspays|null findOneBy(array $criteria, array $orderBy = null)
 * @method Souspays[]    findAll()
 * @method Souspays[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SouspaysRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Souspays::class);
    }

    // Exemple de méthode personnalisée :
    /*
    public function findByLibsouspays(string $value): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.libsouspays = :val')
            ->setParameter('val', $value)
            ->orderBy('s.seqsouspays', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    */

    // public function findOneBySomeField($value): ?Souspays
    // {
    //     return $this->createQueryBuilder('s')
    //         ->andWhere('s.exampleField = :val')
    //         ->setParameter('val', $value)
    //         ->getQuery()
    //         ->getOneOrNullResult()
    //     ;
    // }
}
