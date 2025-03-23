<?php

namespace App\Controller\Publisher;

use App\Controller\Abstract\AbstractGetEntityAction;
use App\Entity\Publisher;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

class GetPublisherAction extends AbstractGetEntityAction
{
    public function __construct(
        protected readonly CacheService $cacheService
    ) {
        parent::__construct($cacheService);
    }

    #[Route('/api/publisher/{id}', name: 'app_get_publisher_item', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a Publisher item",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(
                ref: new Model(
                    type: Publisher::class,
                    groups: ["getPublisher"]))))]
    #[OA\Parameter(name: "id",
        description: "Publisher ID",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer"))]
    #[OA\Tag(name: "Publisher")]
    public function __invoke(Publisher $publisher): JsonResponse
    {
        return $this->getEntityData(
            $publisher,
            'Publisher',
            'publisher',
            'getPublisher',
            ['publisher']
        );
    }
}