<?php

namespace App\Controller\Publisher;

use App\Controller\Abstract\AbstractEntityController;
use App\Entity\Publisher;
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

class CreatePublisherAction extends AbstractEntityController
{
    private array $fieldConfig;

    public function __construct(
        protected EntityManagerInterface $manager,
        protected SerializerInterface    $serializer,
        protected EntityFieldManager     $fieldManager,
        protected ValidatorInterface     $validator,
        private readonly GameRepository  $gameRepository
    ) {
        parent::__construct($manager, $serializer, $validator, $fieldManager);

        $this->fieldConfig = [
            'required' => ['title'],
            'optional' => ['slug', 'country', 'website'],
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

    #[Route('/api/publisher', name: 'app_create_publisher', requirements: ['_format' => 'json'], methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN', message: 'You do not have sufficient permissions')]
    #[OA\Response(response: 201, description: "Publisher item successfully created")]
    #[OA\Response(response: 400, description: "Validation failed - invalid data provided")]
    #[OA\Response(response: 401, description: "Unauthorized - JWT Token not found")]
    #[OA\Response(response: 403, description: "Access denied - insufficient permissions")]
    #[OA\RequestBody(
        description: "Publisher data",
        required: true, content: new OA\MediaType(
        mediaType: "application/json",
        schema: new OA\Schema(required: ["title"],
            properties: [
                new OA\Property(property: "title", type: "string", example: "Must be unique"),
                new OA\Property(property: "slug", type: "string", example: ""),
                new OA\Property(property: "country", type: "string"),
                new OA\Property(property: "website", type: "string", example: "https://example.com"),
                new OA\Property(property: "game", type: "array",
                    items: new OA\Items(type: "string"), example: ["ID1", "ID2"])
            ])))]
    #[OA\Tag(name: "Publisher")]
    #[Security(name: "bearerAuth")]
    public function __invoke(Request $request): JsonResponse
    {
        $content = $request->toArray();
        $publisher = new Publisher();
        $validationErrors = new ConstraintViolationList();

        $this->processFieldsFromConfig($publisher, $content, $this->fieldConfig, $validationErrors);

        $errorResponse = $this->processErrors($publisher, $validationErrors);
        if ($errorResponse) {
            return $errorResponse;
        }

        $this->manager->persist($publisher);
        $this->manager->flush();

        return $this->createSuccessResponse($publisher, 'getPublisher', Response::HTTP_CREATED);
    }
}