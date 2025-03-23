<?php

namespace App\Controller\User;

use App\Controller\Abstract\AbstractUpdateEntityAction;
use App\Entity\User;
use App\Service\EntityField\Configuration\EntityConfigurationFactoryInterface;
use App\Service\EntityField\Processor\ErrorProcessor;
use App\Service\EntityField\Processor\FieldProcessor;
use App\Service\EntityField\Processor\ResponseProcessor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Nelmio\ApiDocBundle\Attribute\Security;
use OpenApi\Attributes as OA;

class UpdateUserAction extends AbstractUpdateEntityAction
{
    private array $fieldConfig;

    public function __construct(
        EntityManagerInterface $manager,
        FieldProcessor $fieldProcessor,
        ErrorProcessor $errorProcessor,
        ResponseProcessor $responseProcessor,
        EntityConfigurationFactoryInterface $configFactory
    ) {
        parent::__construct($manager, $fieldProcessor, $errorProcessor, $responseProcessor);

        $this->fieldConfig = $configFactory->createForUpdate('user');
    }

    #[Route('/api/user/{id}', name: 'app_update_user', requirements: ['_format' => 'json'], methods: ['PATCH'])]
    #[IsGranted('ROLE_ADMIN', message: 'You do not have sufficient permissions')]
    #[OA\Response(response: 200, description: "User item successfully updated")]
    #[OA\Response(response: 400, description: "Validation failed - invalid data provided")]
    #[OA\Response(response: 401, description: "Unauthorized - JWT Token not found")]
    #[OA\Response(response: 403, description: "Access denied - insufficient permissions")]
    #[OA\RequestBody(
        description: "User data",
        required: false,
        content: new OA\MediaType(
            mediaType: "application/json",
            schema: new OA\Schema(
                properties: [
                    new OA\Property(property: "nickname", type: "string", example: "Edited Unique Nickname"),
                    new OA\Property(property: "email", type: "string", example: "edited_unique_email@gmail.com"),
                    new OA\Property(property: "password", type: "string", example: "password"),
                    new OA\Property(property: "roles", type: "array",
                        items: new OA\Items(type: "string"), example: ["ROLE_USER"]),
                    new OA\Property(property: "twitchAccount", type: "string", example: "https://twitch.com/user"),
                    new OA\Property(property: "avatar", type: "string", example: "avatar.jpg"),
                    new OA\Property(property: "news", type: "array",
                        items: new OA\Items(type: "string"), example: ["3", "4"]),
                    new OA\Property(property: "review", type: "array",
                        items: new OA\Items(type: "string"), example: ["3", "4"]),
                    new OA\Property(property: "comment", type: "array",
                        items: new OA\Items(type: "string"), example: ["3", "4"])
                ])))]
    #[OA\Tag(name: "User")]
    #[Security(name: "bearerAuth")]
    public function __invoke(Request $request, User $user): JsonResponse
    {
        $content = $request->toArray();

        return $this->updateEntityData($user, $content, $this->fieldConfig, 'getUserr');
    }
}
