<?php

namespace App\Controller\Publisher;

use App\Controller\Abstract\AbstractGetMetaEntityCollectionAction;
use App\Entity\Publisher;
use App\Repository\PublisherRepository;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

class GetPublisherCollectionAction extends AbstractGetMetaEntityCollectionAction
{
    public function __construct(
        PublisherRepository $repository,
        CacheService $cacheService
    ) {
        parent::__construct($repository, $cacheService);
    }
    #[Route('/api/publisher', name: 'app_get_publisher_collection', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a Publisher collection",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(
                ref: new Model(
                    type: Publisher::class,
                    groups: ["getPublisherCollection"]
                ))))]
    #[OA\Tag(name: "Publisher")]
    public function __invoke(): JsonResponse
    {
        return $this->getEntityData(
            'Publisher',
            'publisher',
            'getPublisherCollection',
            ['publisher']
        );
    }
}