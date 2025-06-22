<?php

namespace App\Repository;

use App\Entity\FraisModif;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FraisModif>
 *
 * @method FraisModif|null find($id, $lockMode = null, $lockVersion = null)
 * @method FraisModif|null findOneBy(array $criteria, array $orderBy = null)
 * @method FraisModif[]    findAll()
 * @method FraisModif[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FraisModifRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FraisModif::class);
    }

//    /**
//     * @return FraisModif[] Returns an array of FraisModif objects
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

//    public function findOneBySomeField($value): ?FraisModif
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
