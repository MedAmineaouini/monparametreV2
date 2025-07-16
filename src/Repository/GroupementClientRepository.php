<?php

namespace App\Repository;

use App\Entity\GroupementClient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GroupementClient|null find($id, $lockMode = null, $lockVersion = null)
 * @method GroupementClient|null findOneBy(array $criteria, array $orderBy = null)
 * @method GroupementClient[]    findAll()
 * @method GroupementClient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupementClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupementClient::class);
    }

    // Exemple de méthode personnalisée
    public function findNonArchives()
    {
        return $this->createQueryBuilder('g')
            ->where('g.archiver = 0')
            ->getQuery()
            ->getResult();
    }
}