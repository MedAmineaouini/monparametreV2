<?php

namespace App\Repository;

use App\Entity\BaseCure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BaseCure>
 *
 * @method BaseCure|null find($id, $lockMode = null, $lockVersion = null)
 * @method BaseCure|null findOneBy(array $criteria, array $orderBy = null)
 * @method BaseCure[]    findAll()
 * @method BaseCure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BaseCureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BaseCure::class);
    }

//    /**
//     * @return BaseCure[] Returns an array of BaseCure objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BaseCure
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
