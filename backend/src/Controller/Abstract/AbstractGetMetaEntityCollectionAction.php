<?php

namespace App\Controller\Abstract;

use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractGetMetaEntityCollectionAction
{
    public function __construct(
        protected readonly mixed $repository,
        protected readonly CacheService $cacheService
    ) {
    }
    protected function getEntityData(
        string $entityType,
        string $cachePrefix,
        string $serializationGroup,
        array $cacheGroups
    ): JsonResponse {

        $idCache = "get{$entityType}CollectionAction";

        $jsonData = $this->cacheService->getCachedData(
            $idCache,
            "{$cachePrefix}Cache",
            function() {
                return $this->repository->findAll();
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