<?php

namespace App\Controller\Game;

use App\Controller\Abstract\AbstractEntityController;
use App\Entity\Game;
use App\Repository\DeveloperRepository;
use App\Repository\GenreRepository;
use App\Repository\NewsRepository;
use App\Repository\PlatformRepository;
use App\Repository\PublisherRepository;
use App\Repository\ReviewRepository;
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
use App\Service\EntityField\FieldManager;
use OpenApi\Attributes as OA;

class UpdateGameAction extends AbstractEntityController
{
    private array $fieldConfig;
    public function __construct(
        protected SerializerInterface        $serializer,
        protected EntityManagerInterface     $manager,
        protected FieldManager               $fieldManager,
        private readonly DeveloperRepository $developerRepository,
        private readonly GenreRepository     $genreRepository,
        private readonly PublisherRepository $publisherRepository,
        private readonly PlatformRepository  $platformRepository,
        private readonly NewsRepository      $newsRepository,
        private readonly ReviewRepository    $reviewRepository,
        protected ValidatorInterface         $validator
    ) {
        parent::__construct($manager, $serializer, $validator, $fieldManager);

        $this->fieldConfig = [
            'optional' => ['title', 'slug', 'content', 'summary', 'status',
                'cover', 'language', 'website', 'platformRequirementsLevel',
                'ageRating', 'releaseDateWorld', 'releaseDateFrance'],
            'relations' => [
                'developer' => [
                    'type' => 'collection',
                    'repository' => $this->developerRepository,
                    'numericField' => 'id',
                    'stringField' => 'title'
                ],
                'genre' => [
                    'type' => 'collection',
                    'repository' => $this->genreRepository,
                    'numericField' => 'id',
                    'stringField' => 'title'
                ],
                'platform' => [
                    'type' => 'collection',
                    'repository' => $this->platformRepository,
                    'numericField' => 'id',
                    'stringField' => 'title'
                ],
                'publisher' => [
                    'type' => 'collection',
                    'repository' => $this->publisherRepository,
                    'numericField' => 'id',
                    'stringField' => 'title'
                ],
                'news' => [
                    'type' => 'collection',
                    'repository' => $this->newsRepository,
                    'numericField' => 'id',
                    'stringField' => 'title'
                ],
                'review' => [
                    'type' => 'collection',
                    'repository' => $this->reviewRepository,
                    'numericField' => 'id',
                    'stringField' => 'title'
                ],
            ]
        ];
    }

    #[Route('/api/game/{id}', name: 'app_update_game_item', requirements: ['_format' => 'json'], methods: ['PATCH'])]
    #[IsGranted('ROLE_ADMIN', message: 'You do not have sufficient permissions')]
    #[OA\Response(response: 200, description: "Game item successfully updated")]
    #[OA\Response(response: 400, description: "Validation failed - invalid data provided")]
    #[OA\Response(response: 401, description: "Unauthorized - JWT Token not found")]
    #[OA\Response(response: 403, description: "Access denied - insufficient permissions")]
    #[OA\RequestBody(
        description: "Game data",
        required: true,
        content: new OA\MediaType(
            mediaType: "application/json",
            schema: new OA\Schema(
                properties: [
                    new OA\Property(property: "title", type: "string", example: "Edited Unique Title"),
                    new OA\Property(property: "slug", type: "string", example: ""),
                    new OA\Property(property: "content", type: "string", example: "Minimum 10 characters"),
                    new OA\Property(property: "summary", type: "string", example: "Minimum 10 characters"),
                    new OA\Property(property: "status", type: "string",
                        enum: ["Published", "Draft", "Archived", "Deleted"], example: "Deleted"),
                    new OA\Property(property: "cover", type: "string", example: "cover.jpg"),
                    new OA\Property(property: "releaseDateWorld", type: "string", example: '20/11/2000'),
                    new OA\Property(property: "releaseDateFrance", type: "string", example: '03/12/2016'),
                    new OA\Property(property: "platformRequirementsLevel", type: "string",
                        enum: ["Low", "Medium", "High"], example: "Low"),
                    new OA\Property(property: "ageRating", type: "string",
                        enum: ["3+", "7+", "12+", "16+", "18+"], example: "3+"),
                    new OA\Property(property: "language", type: "array",
                        items: new OA\Items(type: "string"), example: ["ru", "es"]),
                    new OA\Property(property: "website", type: "string", example: "https://new-example.com"),
                    new OA\Property(property: "developer", type: "array",
                        items: new OA\Items(type: "string"), example: ["3", "4"]),
                    new OA\Property(property: "genre", type: "array",
                        items: new OA\Items(type: "string"), example: ["3", "4"]),
                    new OA\Property(property: "platform", type: "array",
                        items: new OA\Items(type: "string"), example: ["3", "4"]),
                    new OA\Property(property: "publisher", type: "array",
                        items: new OA\Items(type: "string"), example: ["3", "4"]),
                    new OA\Property(property: "news", type: "array",
                        items: new OA\Items(type: "string"), example: ["3", "4"]),
                    new OA\Property(property: "review", type: "array",
                        items: new OA\Items(type: "string"), example: ["3", "4"])
                ])))]
    #[OA\Tag(name: "Game")]
    #[Security(name: "bearerAuth")]
    public function __invoke(Request $request, Game $game): JsonResponse {

        $content = $request->toArray();
        $validationErrors = new ConstraintViolationList();

        $this->processFieldsFromConfig($game, $content, $this->fieldConfig, $validationErrors);

        $errorResponse = $this->processErrors($game, $validationErrors);
        if ($errorResponse) {
            return $errorResponse;
        }

        $this->manager->flush();

        return $this->createSuccessResponse($game, 'getGame', Response::HTTP_OK);
    }
}