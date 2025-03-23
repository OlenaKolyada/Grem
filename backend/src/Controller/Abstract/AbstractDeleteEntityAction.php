<?php

namespace App\Controller\Abstract;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

abstract class AbstractDeleteEntityAction
{
    public function __construct(
        protected readonly EntityManagerInterface $manager,
        protected readonly TagAwareCacheInterface $cache
    ) {
    }

    protected function deleteEntity(
        object $entity,
        string $cacheTag
    ): Response {
        $this->cache->invalidateTags([$cacheTag]);
        $this->manager->remove($entity);
        $this->manager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}