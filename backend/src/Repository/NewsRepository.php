<?php

namespace App\Repository;

use App\Entity\News;
use Doctrine\Persistence\ManagerRegistry;

class NewsRepository extends BaseEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
    }
}