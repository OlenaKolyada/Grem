<?php

namespace App\Service\EntityField\Handler;

use App\Service\EntityField\FieldErrorHandler;
use App\Service\EntityField\FieldTypeDetector;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class RelationFieldHandler extends AbstractFieldHandler
{
    // ManyToOne
    public function __construct(
        private readonly FieldTypeDetector $fieldTypeDetector,
        private readonly FieldErrorHandler $errorHandler
    ) {
    }

    public function supports(string $fieldType): bool
    {
        return in_array($fieldType, ['entity', 'relation', 'manytoone']);
    }

    public function isRelationField(object $entity, string $fieldName): bool
    {
        return $this->fieldTypeDetector->isRelationField($entity, $fieldName);
    }

    public function handleRelationField(
        object $entity,
        array $data,
        string $fieldName,
        object $repository,
        array $searchConfig,
        ConstraintViolationListInterface $errors,
        bool $isRequired = false,
        string $errorMessage = null
    ): bool {
        if (!isset($data[$fieldName]) && !$isRequired) {
            return true;
        }

        if (!isset($data[$fieldName]) && $isRequired) {
            $this->errorHandler->addError(
                $entity,
                $fieldName,
                $errorMessage ?? ucfirst($fieldName) . ' is required',
                null,
                $errors
            );
            return false;
        }

        $relatedEntity = null;

        $numericField = $searchConfig['numericField'] ?? 'id';
        $stringField = $searchConfig['stringField'] ?? null;

        if (is_numeric($data[$fieldName]) && $numericField) {
            $relatedEntity = $repository->findOneBy([$numericField => $data[$fieldName]]);
        } elseif ($stringField) {
            $relatedEntity = $repository->findOneBy([$stringField => $data[$fieldName]]);
        }

        if ($relatedEntity === null && $isRequired) {
            $this->errorHandler->addError(
                $entity,
                $fieldName,
                $errorMessage ?? ucfirst($fieldName) . ' entity not found',
                $data[$fieldName],
                $errors
            );
            return false;
        }

        if ($relatedEntity !== null) {
            $setter = 'set' . ucfirst($fieldName);
            $entity->$setter($relatedEntity);
        }

        return true;
    }
}