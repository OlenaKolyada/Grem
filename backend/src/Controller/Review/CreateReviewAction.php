<?php

namespace App\Controller\Review;

use App\Controller\Abstract\AbstractEntityController;
use App\Entity\Review;
use App\Repository\GameRepository;
use App\Repository\TagRepository;
use App\Repository\UserRepository;
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
use App\Service\EntityField\FieldManager;

class CreateReviewAction extends AbstractEntityController
{
    private array $fieldConfig;
    public function __construct(
        protected SerializerInterface    $serializer,
        protected EntityManagerInterface $manager,
        protected FieldManager           $fieldManager,
        private readonly UserRepository  $userRepository,
        private readonly TagRepository   $tagRepository,
        private readonly GameRepository  $gameRepository,
        protected ValidatorInterface     $validator
    ) {
        parent::__construct($manager, $serializer, $validator, $fieldManager);

        $this->fieldConfig = [
            'required' => ['title', 'content', 'summary', 'status'],
            'optional' => ['slug', 'gameRating', 'cover'],
            'relations' => [
                'author' => [
                    'type' => 'entity',
                    'repository' => $this->userRepository,
                    'numericField' => 'id',
                    'stringField' => 'title'
                ],
                'tag' => [
                    'type' => 'collection',
                    'repository' => $this->tagRepository,
                    'numericField' => 'id',
                    'stringField' => 'title'
                ],
                'game' => [
                    'type' => 'collection',
                    'repository' => $this->gameRepository,
                    'numericField' => 'id',
                    'stringField' => 'title'
                ],
            ]
        ];
    }

    #[Route('/api/review',
        name: 'app_create_review_item',
        requirements: ['_format' => 'json'],
        methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN', message: 'You do not have sufficient permissions')]
    #[OA\Response(response: 201, description: "Review item successfully created")]
    #[OA\Response(response: 400, description: "Validation failed - invalid data provided")]
    #[OA\Response(response: 401, description: "Unauthorized - JWT Token not found")]
    #[OA\Response(response: 403, description: "Access denied - insufficient permissions")]
    #[OA\RequestBody(
        description: "Review data",
        required: true,
        content: new OA\MediaType(
            mediaType: "application/json",
            schema: new OA\Schema(
                required: ["title", "status", "content", "summary"],
                properties: [
                    new OA\Property(property: "title", type: "string", example: "Must be unique"),
                    new OA\Property(property: "slug", type: "string", example: ""),
                    new OA\Property(property: "content", type: "string", example: "Minimum 10 characters"),
                    new OA\Property(property: "summary", type: "string", example: "Minimum 10 characters"),
                    new OA\Property(property: "status", type: "string",
                        enum: ["Published", "Draft", "Archived", "Deleted"],
                        example: "Published"),
                    new OA\Property(property: "gameRating", type: "integer", example: 5),
                    new OA\Property(property: "cover", type: "string", example: "cover.jpg"),
                    new OA\Property(property: "author", type: "string", example: "ID"),
                    new OA\Property(property: "tag", type: "array",
                        items: new OA\Items(type: "string"), example: ["ID1", "ID2"]),
                    new OA\Property(property: "game", type: "array",
                        items: new OA\Items(type: "string"), example: ["ID1", "ID2"])
                ])))]
    #[OA\Tag(name: "Review")]
    #[Security(name: "bearerAuth")]
    public function __invoke(Request $request): JsonResponse {

        $content = $request->toArray();
        $review = new Review();

        $validationErrors = new ConstraintViolationList();

        $this->processFieldsFromConfig($review, $content, $this->fieldConfig, $validationErrors);

        $errorResponse = $this->processErrors($review, $validationErrors);
        if ($errorResponse) {
            return $errorResponse;
        }

        $this->manager->persist($review);
        $this->manager->flush();

        return $this->createSuccessResponse($review, 'getReview', Response::HTTP_CREATED);
    }
}