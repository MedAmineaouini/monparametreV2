<?php


namespace App\Repository;

use App\Entity\TypeAssur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeAssur>
 *
 * @method TypeAssur|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeAssur|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeAssur[]    findAll()
 * @method TypeAssur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeAssurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeAssur::class);
    }

    // 🔍 Exemple de méthode personnalisée :
    public function findByLib(string $lib): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.libTypeAssur LIKE :lib')
            ->setParameter('lib', "%$lib%")
            ->orderBy('t.libTypeAssur', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
