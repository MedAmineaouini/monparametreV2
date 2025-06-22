<?php

namespace App\Repository;

use App\Entity\Typeprod;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Typeprod>
 *
 * @method Typeprod|null find($id, $lockMode = null, $lockVersion = null)
 * @method Typeprod|null findOneBy(array $criteria, array $orderBy = null)
 * @method Typeprod[]    findAll()
 * @method Typeprod[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeprodRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Typeprod::class);
    }

    // Exemples de requêtes personnalisées

    /*
    public function findByLibtypeprod(string $value): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.LIBTYPEPROD = :val')
            ->setParameter('val', $value)
            ->orderBy('t.SEQTYPEPROD', 'ASC')
            ->getQuery()
            ->getResult();
    }
    */
}
