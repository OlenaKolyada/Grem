<?php

namespace App\Controller\Tag;

use App\Controller\Abstract\AbstractGetMetaEntityCollectionAction;
use App\Entity\Tag;
use App\Repository\TagRepository;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

class GetTagCollectionAction extends AbstractGetMetaEntityCollectionAction
{
    public function __construct(
        TagRepository $repository,
        CacheService $cacheService
    ) {
        parent::__construct($repository, $cacheService);
    }
    #[Route('/api/tag', name: 'app_get_tag_collection', methods: ['GET'])]
    #[OA\Response(response: 200,
        description: "Get a Tag collection",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(
                ref: new Model(
                    type: Tag::class,
                    groups: ["getTagCollection"]
                ))))]
    #[OA\Tag(name: "Tag")]
    public function __invoke(): JsonResponse
    {
        return $this->getEntityData(
            'Tag',
            'tag',
            'getTagCollection',
            ['tag']
        );
    }
}