<?php

namespace App\Repository;

use App\Entity\Ville;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ville>
 */
class VilleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ville::class);
    }

    public function save(Ville $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Ville $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Ville[] Returns an array of Ville objects
     */
    public function findAllOrderedByName(): array
    {
        return $this->createQueryBuilder('v')
            ->orderBy('v.libville', 'ASC')
            ->getQuery()
            ->getResult();
    }
    public function findVillesByPaysNotEqual($paysId): array
    {
        return $this->createQueryBuilder('v')
            ->leftJoin('v.pays', 'p')
            ->where('p.idpays != :paysId OR v.pays IS NULL')
            ->setParameter('paysId', $paysId)
            ->orderBy('v.libville', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Trouve les villes par pays
     */
    public function findVillesByPays($paysId): array
    {
        return $this->createQueryBuilder('v')
            ->leftJoin('v.pays', 'p')
            ->where('p.idpays = :paysId')
            ->setParameter('paysId', $paysId)
            ->orderBy('v.libville', 'ASC')
            ->getQuery()
            ->getResult();
    }
}