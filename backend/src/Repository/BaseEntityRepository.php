<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class BaseEntityRepository extends ServiceEntityRepository implements LatestEntityInterface
{
    public function findByWithPagination(array $criteria, int $page, int $limit): array
    {
        $qb = $this->createQueryBuilder('e');

        if (isset($criteria['status'])) {
            $qb->andWhere('e.status = :status')
                ->setParameter('status', $criteria['status']);
        } else {
            $qb->andWhere('e.status = :defaultStatus')
                ->setParameter('defaultStatus', 'Published');
        }

        $qb->orderBy('e.updatedAt', 'DESC');

        $totalQb = clone $qb;
        $totalItems = count($totalQb->getQuery()->getResult());

        $qb->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        return [
            'items' => $qb->getQuery()->getResult(),
            'pagination' => [
                'totalItems' => $totalItems,
                'page' => $page,
                'limit' => $limit,
                'pages' => ceil($totalItems / $limit)
            ]
        ];
    }

    /**
     * Находит последний опубликованный элемент
     *
     * @return object|null
     */
    public function findLatest(): ?object
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.status = :status')
            ->setParameter('status', 'Published')
            ->orderBy('e.updatedAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}