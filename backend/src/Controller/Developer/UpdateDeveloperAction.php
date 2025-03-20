<?php

namespace App\Controller\Developer;

use App\Controller\Abstract\AbstractEntityController;
use App\Entity\Developer;
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
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;

class UpdateDeveloperAction extends AbstractEntityController
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
            'optional' => ['title', 'slug', 'country', 'website'],
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

    #[Route('/api/developer/{id}',
        name: 'app_update_developer',
        requirements: ['_format' => 'json'],
        methods: ['PATCH'])]
    #[IsGranted('ROLE_ADMIN', message: 'You do not have sufficient permissions')]
    #[OA\Response(response: 200, description: "Developer item successfully updated")]
    #[OA\Response(response: 400, description: "Validation failed - invalid data provided")]
    #[OA\Response(response: 401, description: "Unauthorized - JWT Token not found")]
    #[OA\Response(response: 403, description: "Access denied - insufficient permissions")]
    #[OA\Parameter(
        name: "id",
        description: "Developer ID",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\RequestBody(
        description: "Developer data",
        required: true,
        content: new OA\MediaType(
            mediaType: "application/json",
            schema: new OA\Schema(
                properties: [
                    new OA\Property(property: "title",type: "string", example: "Must be unique"),
                    new OA\Property(property: "slug", type: "string", example: ""),
                    new OA\Property(property: "country", type: "string"),
                    new OA\Property(property: "website", type: "string", example: "https://example.com"),
                    new OA\Property(property: "game", type: "array",
                        items: new OA\Items(type: "string"), example: ["ID1", "ID2"])
                ])))]
    #[OA\Tag(name: "Developer")]
    #[Security(name: "bearerAuth")]
    public function __invoke(Request $request, Developer $developer): JsonResponse
    {
        $content = $request->toArray();
        $validationErrors = new ConstraintViolationList();

        $this->processFieldsFromConfig($developer, $content, $this->fieldConfig, $validationErrors);

        $errorResponse = $this->processErrors($developer, $validationErrors);
        if ($errorResponse) {
            return $errorResponse;
        }

        $this->manager->flush();

        return $this->createSuccessResponse($developer, 'getDeveloper', Response::HTTP_OK);
    }
}