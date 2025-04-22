<?php

namespace App\Controller\Abstract;

use App\Service\EntityField\Processor\ErrorProcessor;
use App\Service\EntityField\Processor\FieldProcessor;
use App\Service\EntityField\Processor\ResponseProcessor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolationList;

abstract class AbstractCreateEntityAction
{
    public function __construct(
        protected readonly EntityManagerInterface $manager,
        protected readonly FieldProcessor $fieldProcessor,
        protected readonly ErrorProcessor $errorProcessor,
        protected readonly ResponseProcessor $responseProcessor
    ) {
    }

    protected function createEntityData(
        object $entity,
        array $content,
        array $fieldConfig,
        string $serializationGroup,
        int $statusCode = 201
    ): JsonResponse {
        $validationErrors = new ConstraintViolationList();

        $this->fieldProcessor->processFieldsFromConfig($entity, $content, $fieldConfig, $validationErrors);

        $errorResponse = $this->errorProcessor->processErrors($entity, $validationErrors);
        if ($errorResponse) {
            return $errorResponse;
        }

        $this->manager->persist($entity);
        $this->manager->flush();

        return $this->responseProcessor->createSuccessResponse($entity, $serializationGroup, $statusCode);
    }
}
