<?php

namespace App\Controller\Abstract;

use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @template T
 */

abstract class AbstractGetCoreEntityAction
{
    public function __construct(
        protected readonly CacheService $cacheService
    ) {
    }

    protected function getEntityData(
        object $entity,
        string $entityType,
        string $cachePrefix,
        string $serializationGroup,
        array $cacheGroups
    ): JsonResponse
    {

        $idCache = "get{$entityType}Action-" . $entity->getId();

        $jsonData = $this->cacheService->getCachedData(
            $idCache,
            "{$cachePrefix}Cache",
            function () use ($entity) {
                return $entity;
            },
            $serializationGroup,
            $cacheGroups
        );

        return new JsonResponse(
            $jsonData,
            Response::HTTP_OK,
            [],
            true
        );
    }
}