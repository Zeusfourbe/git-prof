<?php

namespace App\Repository;

use App\Entity\Coaster;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Coaster>
 */
class CoasterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coaster::class);
    }

    public function findFiltered(
        string $parkId = '',
        string $categoryId = '',
        int $count = 20,
        int $page = 1,
    ): Paginator {
        $begin = ($page - 1) * $count; // Calcul de l'offset

        $qb = $this->createQueryBuilder('c')
            ->leftJoin('c.park', 'p')
            ->leftJoin('c.categories', 'cat')
            ->orderBy('c.name', 'ASC')
            ->addOrderBy('c.id', 'ASC')
            ->setMaxResults($count)   // LIMIT
            ->setFirstResult($begin); // OFFSET

        if ($parkId !== '') {
            $qb->andWhere('p.id = :parkId')
                ->setParameter('parkId', (int) $parkId);
        }

        if ($categoryId !== '') {
            $qb->andWhere('cat.id = :categoryId')
                ->setParameter('categoryId', (int) $categoryId);
        }

        return new Paginator($qb->getQuery());
    }
}
