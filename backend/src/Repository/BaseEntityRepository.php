<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class BaseEntityRepository extends ServiceEntityRepository
{
    public function findLatest(): ?object
    {
        $alias = $this->getAlias();
        return $this->createQueryBuilder($alias)
            ->andWhere("$alias.status = :status")
            ->setParameter('status', 'Published')
            ->orderBy("$alias.updatedAt", 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByStatusWithSorting(
        string $status,
        int $page,
        int $limit,
        string $sortField,
        string $sortDirection
    ): array {
        $alias = $this->getAlias();

        $qb = $this->createQueryBuilder($alias)
            ->where("$alias.status = :status")
            ->setParameter('status', $status)
            ->orderBy("$alias.$sortField", $sortDirection);

        $totalQb = clone $qb;
        $totalItems = count($totalQb->getQuery()->getResult());

        $qb->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        $items = $qb->getQuery()->getResult();

        return [
            'items' => $items,
            'pagination' => [
                'totalItems' => $totalItems,
                'page' => $page,
                'limit' => $limit,
                'pages' => ceil($totalItems / $limit)
            ]
        ];
    }

    protected function getAlias(): string
    {
        return 'e';
    }
}