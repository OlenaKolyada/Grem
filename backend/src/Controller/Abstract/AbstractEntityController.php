<?php

namespace App\Controller\Abstract;

use App\Service\EntityField\EntityFieldManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractEntityController
{
    public function __construct(
        protected EntityManagerInterface $manager,
        protected SerializerInterface $serializer,
        protected ValidatorInterface $validator,
        protected EntityFieldManager $fieldManager
    ) {
    }

    /**
     * Обрабатывает поля сущности на основе конфигурации
     */
    protected function processFieldsFromConfig(
        object $entity,
        array $content,
        array $fieldConfig,
        ConstraintViolationList $validationErrors
    ): void {
        // Обработка обязательных полей
        if (!empty($fieldConfig['required'])) {
            $this->fieldManager->handleFields(
                $entity,
                $content,
                $fieldConfig['required'],
                $validationErrors,
                true
            );
        }

        // Обработка необязательных полей
        if (!empty($fieldConfig['optional'])) {
            $this->fieldManager->handleFields(
                $entity,
                $content,
                $fieldConfig['optional']
            );
        }

        // Обработка отношений
        if (isset($fieldConfig['relations'])) {
            foreach ($fieldConfig['relations'] as $fieldName => $config) {
                $repository = $config['repository'];

                if ($config['type'] === 'collection') {
                    $this->fieldManager->handleCollectionField(
                        $entity,
                        $content,
                        $fieldName,
                        $repository,
                        [
                            'numericField' => $config['numericField'] ?? 'id',
                            'stringField' => $config['stringField'] ?? 'title'
                        ],
                        $validationErrors,
                        $config['required'] ?? false,
                        null,
                        $config['clearExisting'] ?? true // Передаем настройку очистки
                    );
                } elseif ($config['type'] === 'entity') {
                    $this->fieldManager->handleEntityField(
                        $entity,
                        $content,
                        $fieldName,
                        $repository,
                        [
                            'numericField' => $config['numericField'] ?? 'id',
                            'stringField' => $config['stringField'] ?? 'title'
                        ],
                        $validationErrors,
                        $config['required'] ?? false
                    );
                }
            }
        }
    }

    protected function processErrors(object $entity, ConstraintViolationList $validationErrors): ?JsonResponse
    {
        $errors = $this->validator->validate($entity);

        foreach ($validationErrors as $error) {
            $errors->add($error);
        }

        if ($errors->count() > 0) {
            return new JsonResponse(
                $this->serializer->serialize($errors, 'json'),
                JsonResponse::HTTP_BAD_REQUEST,
                [],
                true
            );
        }

        return null;
    }

    protected function createSuccessResponse(object $entity, string $group, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        $jsonData = $this->serializer->serialize(
            $entity,
            'json',
            [
                'groups' => $group,
                'ignored_attributes' => [strtolower(basename(get_class($entity)))]
            ]
        );

        return new JsonResponse(
            $jsonData,
            $statusCode,
            [],
            true
        );
    }
}