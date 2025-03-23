<?php

namespace App\Controller\Abstract;

use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractGetMetaEntityCollectionAction {
    public function __construct(
        protected readonly mixed $repository,
        protected readonly CacheService $cacheService
    ) {
    }

    protected function getEntityData(
        string $entityType,
        string $cachePrefix,
        string $serializationGroup,
        array $cacheGroups,
        array $criteria = [],
        ?string $criteriaIdSuffix = null
    ): JsonResponse {
        $idCache = "get{$entityType}CollectionAction";

        if (!empty($criteria) && $criteriaIdSuffix) {
            $idCache .= "-" . $criteriaIdSuffix;
        }

        $jsonData = $this->cacheService->getCachedData(
            $idCache,
            "{$cachePrefix}Cache",
            function() use ($criteria) {
                return empty($criteria)
                    ? $this->repository->findAll()
                    : $this->repository->findBy($criteria);
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