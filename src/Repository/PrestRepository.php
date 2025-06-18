<?php

namespace App\Repository;

use App\Entity\Prest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Prest>
 *
 * @method Prest|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prest|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prest[]    findAll()
 * @method Prest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prest::class);
    }

//    /**
//     * @return Prest[] Returns an array of Prest objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Prest
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
