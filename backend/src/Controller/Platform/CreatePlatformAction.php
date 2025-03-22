<?php

namespace App\Controller\Platform;

use App\Controller\Abstract\AbstractEntityController;
use App\Entity\Platform;
use App\Repository\GameRepository;
use App\Service\EntityField\FieldManager;
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

class CreatePlatformAction extends AbstractEntityController
{
    private array $fieldConfig;

    public function __construct(
        protected EntityManagerInterface $manager,
        protected SerializerInterface    $serializer,
        protected FieldManager           $fieldManager,
        protected ValidatorInterface     $validator,
        private readonly GameRepository  $gameRepository
    ) {
        parent::__construct($manager, $serializer, $validator, $fieldManager);

        $this->fieldConfig = [
            'required' => ['title'],
            'optional' => ['slug'],
            'relations' => [
                'game' => [
                    'type' => 'collection',
                    'repository' => $this->gameRepository,
                    'numericField' => 'id',
                    'stringField' => 'title'
                ]
            ]
        ];
    }

    #[Route('/api/platform', name: 'app_create_platform', requirements: ['_format' => 'json'], methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN', message: 'You do not have sufficient permissions')]
    #[OA\Response(response: 201, description: "Platform item successfully created")]
    #[OA\Response(response: 400, description: "Validation failed - invalid data provided")]
    #[OA\Response(response: 401, description: "Unauthorized - JWT Token not found")]
    #[OA\Response(response: 403, description: "Access denied - insufficient permissions")]
    #[OA\RequestBody(
        description: "Platform data",
        required: true, content: new OA\MediaType(
        mediaType: "application/json",
        schema: new OA\Schema(required: ["title"],
            properties: [
                new OA\Property(property: "title", type: "string", example: "Must be unique"),
                new OA\Property(property: "slug", type: "string", example: ""),
                new OA\Property(property: "game", type: "array",
                    items: new OA\Items(type: "string"), example: ["ID1", "ID2"])
            ])))]
    #[OA\Tag(name: "Platform")]
    #[Security(name: "bearerAuth")]
    public function __invoke(Request $request): JsonResponse
    {
        $content = $request->toArray();
        $platform = new Platform();
        $validationErrors = new ConstraintViolationList();

        $this->processFieldsFromConfig($platform, $content, $this->fieldConfig, $validationErrors);

        $errorResponse = $this->processErrors($platform, $validationErrors);
        if ($errorResponse) {
            return $errorResponse;
        }

        $this->manager->persist($platform);
        $this->manager->flush();

        return $this->createSuccessResponse($platform, 'getPlatform', Response::HTTP_CREATED);
    }
}