<?php

namespace App\Repository;

use App\Entity\FraisAnnul;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FraisAnnul>
 *
 * @method FraisAnnul|null find($id, $lockMode = null, $lockVersion = null)
 * @method FraisAnnul|null findOneBy(array $criteria, array $orderBy = null)
 * @method FraisAnnul[]    findAll()
 * @method FraisAnnul[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FraisAnnulRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FraisAnnul::class);
    }

//    /**
//     * @return FraisAnnul[] Returns an array of FraisAnnul objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FraisAnnul
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
