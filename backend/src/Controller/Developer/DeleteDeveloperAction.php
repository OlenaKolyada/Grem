<?php

namespace App\Controller\Developer;

use App\Controller\Abstract\AbstractDeleteEntityAction;
use App\Entity\Developer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Nelmio\ApiDocBundle\Attribute\Security;
use OpenApi\Attributes as OA;

class DeleteDeveloperAction extends AbstractDeleteEntityAction
{
    public function __construct(
        EntityManagerInterface $manager,
        TagAwareCacheInterface $cache
    ) {
        parent::__construct($manager, $cache);
    }

    #[Route('/api/developer/{id}', name: 'app_delete_developer', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN', message: 'You do not have sufficient permissions')]
    #[OA\Response(response: 204, description: "Developer item successfully deleted")]
    #[OA\Response(response: 401, description: "Unauthorized - JWT Token not found")]
    #[OA\Response(response: 403, description: "Access denied - insufficient permissions")]
    #[OA\Response(response: 404, description: "Developer not found")]
    #[OA\Parameter(name: "id", description: "Developer ID", in: "path",
        required: true, schema: new OA\Schema(type: "integer")
    )]
    #[OA\Tag(name: "Developer")]
    #[Security(name: "bearerAuth")]
    public function __invoke(Developer $developer): Response
    {
        return $this->deleteEntity($developer, "developerCache");
    }
}