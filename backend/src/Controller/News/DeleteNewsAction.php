<?php

namespace App\Controller\News;

use App\Controller\Abstract\AbstractDeleteEntityAction;
use App\Entity\News;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Nelmio\ApiDocBundle\Attribute\Security;
use OpenApi\Attributes as OA;

class DeleteNewsAction extends AbstractDeleteEntityAction
{
    public function __construct(
        EntityManagerInterface $manager,
        TagAwareCacheInterface $cache
    ) {
        parent::__construct($manager, $cache);
    }

    #[Route('/api/news/{id}', name: 'app_delete_news_item', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN', message: 'You do not have sufficient permissions')]
    #[OA\Response(response: 204, description: "News item successfully deleted")]
    #[OA\Response(response: 401, description: "Unauthorized - JWT Token not found")]
    #[OA\Response(response: 403, description: "Access denied - insufficient permissions")]
    #[OA\Response(response: 404, description: "News not found")]
    #[OA\Parameter(name: "id", description: "News ID", in: "path",
        required: true, schema: new OA\Schema(type: "integer")
    )]
    #[OA\Tag(name: "News")]
    #[Security(name: "bearerAuth")]
    public function __invoke(News $news): Response
    {
        return $this->deleteEntity($news, "newsCache");
    }
}