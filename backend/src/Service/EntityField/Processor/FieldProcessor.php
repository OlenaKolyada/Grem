<?php

namespace App\Service\EntityField\Processor;

use App\Service\EntityField\FieldManager;
use Symfony\Component\Validator\ConstraintViolationList;

readonly class FieldProcessor
{
    public function __construct(
        private FieldManager $fieldManager
    ) {
    }

    public function processFieldsFromConfig(
        object $entity,
        array $content,
        array $fieldConfig,
        ConstraintViolationList $validationErrors
    ): void {

        if (!empty($fieldConfig['required'])) {
            $this->fieldManager->handleFields(
                $entity,
                $content,
                $fieldConfig['required'],
                $validationErrors,
                true
            );
        }

        if (!empty($fieldConfig['optional'])) {
            $this->fieldManager->handleFields(
                $entity,
                $content,
                $fieldConfig['optional']
            );
        }

        if (isset($fieldConfig['relations'])) {
            $this->processRelationFields($entity, $content, $fieldConfig['relations'], $validationErrors);
        }
    }

    private function processRelationFields(
        object $entity,
        array $content,
        array $relations,
        ConstraintViolationList $validationErrors
    ): void {
        foreach ($relations as $fieldName => $config) {
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
                    $config['clearExisting'] ?? true
                );
            } elseif ($config['type'] === 'entity') {
                $this->fieldManager->handleRelationField(
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