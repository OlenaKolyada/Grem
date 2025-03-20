<?php

namespace App\Repository;

use App\Entity\Review;
use Doctrine\Persistence\ManagerRegistry;

class ReviewRepository extends BaseEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }
}