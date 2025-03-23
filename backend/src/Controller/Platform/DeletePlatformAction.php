<?php

namespace App\Controller\Platform;

use App\Controller\Abstract\AbstractDeleteEntityAction;
use App\Entity\Platform;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Nelmio\ApiDocBundle\Attribute\Security;
use OpenApi\Attributes as OA;

class DeletePlatformAction extends AbstractDeleteEntityAction
{
    public function __construct(
        EntityManagerInterface $manager,
        TagAwareCacheInterface $cache
    ) {
        parent::__construct($manager, $cache);
    }
    #[Route('/api/platform/{id}', name: 'app_delete_platform', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN', message: 'You do not have sufficient permissions')]
    #[OA\Response(response: 204, description: "Platform item successfully deleted")]
    #[OA\Response(response: 401, description: "Unauthorized - JWT Token not found")]
    #[OA\Response(response: 403, description: "Access denied - insufficient permissions")]
    #[OA\Response(response: 404, description: "Platform not found")]
    #[OA\Parameter(name: "id", description: "Platform ID", in: "path",
        required: true, schema: new OA\Schema(type: "integer")
    )]
    #[OA\Tag(name: "Platform")]
    #[Security(name: "bearerAuth")]
    public function __invoke(Platform $platform): Response
    {
        return $this->deleteEntity($platform, "platformCache");
    }
}