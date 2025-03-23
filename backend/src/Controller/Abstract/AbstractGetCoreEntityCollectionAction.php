<?php

namespace App\Controller\Abstract;

use App\Service\CacheService;
use App\Trait\PaginationTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @template T
 */
abstract class AbstractGetCoreEntityCollectionAction
{
    use PaginationTrait;

    public function __construct(
        protected readonly mixed $repository,
        protected readonly CacheService $cacheService
    ) {
    }

    protected function getEntityData(
        Request $request,
        string $entityType,
        string $cachePrefix,
        string $serializationGroup,
        array $cacheGroups
    ): JsonResponse {
        $pagination = $this->preparePaginationCriteria($request);
        $status = $pagination['criteria']['status'] ?? 'Published';

        $sortParam = $request->query->get('sort', 'updatedAt:desc');
        [$sortField, $sortDirection] = explode(':', $sortParam);

        $sortField = $sortField ?? 'updatedAt';
        $sortDirection = strtolower($sortDirection ?? 'desc') === 'asc' ? 'ASC' : 'DESC';

        $allowedSortFields = ['updatedAt', 'createdAt'];
        if (!in_array($sortField, $allowedSortFields, true)) {
            throw new \InvalidArgumentException('Invalid sort field');
        }

        $idCache = "get{$entityType}CollectionAction-" .
            $pagination['page'] . "-" .
            $pagination['limit'] . "-" .
            $status . "-" .
            $sortField . "-" .
            strtolower($sortDirection);

        $jsonData = $this->cacheService->getCachedData(
            $idCache,
            "{$cachePrefix}Cache",
            function() use ($pagination, $status, $sortField, $sortDirection) {
                return $this->repository->findByStatusWithSorting(
                    $status,
                    $pagination['page'],
                    $pagination['limit'],
                    $sortField,
                    $sortDirection
                );
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