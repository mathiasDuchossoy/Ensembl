<?php

namespace App\Repository;

use App\Entity\Target;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Target|null find($id, $lockMode = null, $lockVersion = null)
 * @method Target|null findOneBy(array $criteria, array $orderBy = null)
 * @method Target[]    findAll()
 * @method Target[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TargetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Target::class);
    }
}
