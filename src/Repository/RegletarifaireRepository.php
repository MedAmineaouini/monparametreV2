<?php
// src/Repository/RegletarifaireRepository.php

namespace App\Repository;

use App\Entity\Regletarifaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RegletarifaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Regletarifaire::class);
    }
}
