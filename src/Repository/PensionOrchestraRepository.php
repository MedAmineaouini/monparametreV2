<?php

namespace App\Repository;

use App\Entity\PensionOrchestra;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PensionOrchestra>
 *
 * @method PensionOrchestra|null find($id, $lockMode = null, $lockVersion = null)
 * @method PensionOrchestra|null findOneBy(array $criteria, array $orderBy = null)
 * @method PensionOrchestra[]    findAll()
 * @method PensionOrchestra[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PensionOrchestraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PensionOrchestra::class);
    }

//    /**
//     * @return PensionOrchestra[] Returns an array of PensionOrchestra objects
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

//    public function findOneBySomeField($value): ?PensionOrchestra
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
