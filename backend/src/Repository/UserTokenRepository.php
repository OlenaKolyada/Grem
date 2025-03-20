<?php

namespace App\Repository;

use App\Entity\UserToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserToken>
 */
class UserTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserToken::class);
    }

    public function findActiveToken(string $sessionId): ?UserToken
    {
        return $this->createQueryBuilder('t')
            ->where('t.sessionId = :sessionId')
            ->andWhere('t.isRevoked = :isRevoked')
            ->andWhere('t.expiresAt > :now')
            ->setParameter('sessionId', $sessionId)
            ->setParameter('isRevoked', false)
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->getOneOrNullResult();
    }
}
