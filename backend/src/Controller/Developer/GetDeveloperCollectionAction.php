<?php

namespace App\Controller\Developer;

use App\Controller\Abstract\AbstractGetMetaEntityCollectionAction;
use App\Entity\Developer;
use App\Repository\DeveloperRepository;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

class GetDeveloperCollectionAction extends AbstractGetMetaEntityCollectionAction
{
    public function __construct(
        DeveloperRepository $repository,
        CacheService $cacheService
    ) {
        parent::__construct($repository, $cacheService);
    }

    #[Route('/api/developer', name: 'app_get_developer_collection', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a Developer collection",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(
                ref: new Model(
                    type: Developer::class,
                    groups: ["getDeveloperCollection"]
                ))))]
    #[OA\Tag(name: "Developer")]
    public function __invoke(): JsonResponse
    {
        return $this->getEntityData(
            'Developer',
            'developer',
            'getDeveloperCollection',
            ['developer']
        );
    }
}