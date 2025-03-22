<?php

namespace App\Controller\Platform;

use App\Controller\Abstract\AbstractEntityController;
use App\Entity\Platform;
use App\Repository\GameRepository;
use App\Service\EntityField\EntityFieldManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Nelmio\ApiDocBundle\Attribute\Security;
use OpenApi\Attributes as OA;

class UpdatePlatformAction extends AbstractEntityController
{
    private array $fieldConfig;

    public function __construct(
        EntityManagerInterface $manager,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        EntityFieldManager $fieldManager,
        private readonly GameRepository $gameRepository
    ) {
        parent::__construct($manager, $serializer, $validator, $fieldManager);

        $this->fieldConfig = [
            'optional' => ['title', 'slug'],
            'relations' => [
                'game' => [
                    'type' => 'collection',
                    'repository' => $this->gameRepository,
                    'numericField' => 'id',
                    'stringField' => 'title',
                    'clearExisting' => true
                ]
            ]
        ];
    }

    #[Route('/api/platform/{id}',
        name: 'app_update_platform',
        requirements: ['_format' => 'json'],
        methods: ['PATCH'])]
    #[IsGranted('ROLE_ADMIN', message: 'You do not have sufficient permissions')]
    #[OA\Response(response: 200, description: "Platform item successfully updated")]
    #[OA\Response(response: 400, description: "Validation failed - invalid data provided")]
    #[OA\Response(response: 401, description: "Unauthorized - JWT Token not found")]
    #[OA\Response(response: 403, description: "Access denied - insufficient permissions")]
    #[OA\Parameter(
        name: "id",
        description: "Platform ID",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\RequestBody(
        description: "Platform data",
        required: true,
        content: new OA\MediaType(
            mediaType: "application/json",
            schema: new OA\Schema(
                properties: [
                    new OA\Property(property: "title",type: "string", example: "Must be unique"),
                    new OA\Property(property: "slug", type: "string", example: ""),
                    new OA\Property(property: "game", type: "array",
                        items: new OA\Items(type: "string"), example: ["ID1", "ID2"])
                ])))]
    #[OA\Tag(name: "Platform")]
    #[Security(name: "bearerAuth")]
    public function __invoke(Request $request, Platform $platform): JsonResponse
    {
        $content = $request->toArray();
        $validationErrors = new ConstraintViolationList();

        $this->processFieldsFromConfig($platform, $content, $this->fieldConfig, $validationErrors);

        $errorResponse = $this->processErrors($platform, $validationErrors);
        if ($errorResponse) {
            return $errorResponse;
        }

        $this->manager->flush();

        return $this->createSuccessResponse($platform, 'getPlatform', Response::HTTP_OK);
    }
}