<?php

namespace App\Repository;

use App\Entity\TypePromo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypePromo>
 *
 * @method TypePromo|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypePromo|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypePromo[]    findAll()
 * @method TypePromo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypePromoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypePromo::class);
    }

//    /**
//     * @return TypePromo[] Returns an array of TypePromo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TypePromo
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
