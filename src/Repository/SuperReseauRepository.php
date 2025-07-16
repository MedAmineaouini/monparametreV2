<?php


namespace App\Repository;

use App\Entity\SuperReseau;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SuperReseau>
 */
class SuperReseauRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SuperReseau::class);
    }

    /**
     * Trouve un super-réseau par son nom
     */
    public function findByNom(string $nom): ?SuperReseau
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.nomsuperreseau = :nom')
            ->setParameter('nom', $nom)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Sauvegarde une entité avec flush immédiat
     */
    public function save(SuperReseau $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Supprime une entité avec flush immédiat
     */
    public function remove(SuperReseau $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}