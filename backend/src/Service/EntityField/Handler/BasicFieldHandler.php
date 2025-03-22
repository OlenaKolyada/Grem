<?php

namespace App\Service\EntityField\Handler;

use App\Service\EntityField\FieldTypeDetector;
use App\Service\EntityField\FieldErrorHandler;
use Symfony\Component\Validator\ConstraintViolationListInterface;

readonly class BasicFieldHandler implements FieldHandlerInterface
{
    public function __construct(
        private FieldTypeDetector $fieldTypeDetector,
        private FieldErrorHandler $errorHandler
    ) {
    }

    public function supports(string $fieldType): bool
    {
        return in_array($fieldType, ['string', 'text', 'basic']);
    }

    public function handleFields(
        object $entity,
        array $data,
        array $fieldNames,
        ?ConstraintViolationListInterface $errors = null,
        bool $required = false,
        ?string $errorMessage = null
    ): bool {
        $success = true;

        foreach ($fieldNames as $fieldName) {
            if ($this->fieldTypeDetector->isDateField($entity, $fieldName) ||
                $this->fieldTypeDetector->isEnumField($entity, $fieldName) ||
                $this->fieldTypeDetector->isCollectionField($entity, $fieldName) ||
                $this->fieldTypeDetector->isRelationField($entity, $fieldName) ||
                $this->fieldTypeDetector->isArrayField($entity, $fieldName)) {
                continue;
            }

            if ($required && !isset($data[$fieldName])) {
                if ($errors) {
                    $this->errorHandler->addError(
                        $entity,
                        $fieldName,
                        $errorMessage ?? ucfirst($fieldName) . ' is required',
                        null,
                        $errors
                    );
                }
                $success = false;
                continue;
            }

            if (!$required && !isset($data[$fieldName])) {
                continue;
            }

            $setter = 'set' . ucfirst($fieldName);
            if (method_exists($entity, $setter)) {
                $entity->$setter($data[$fieldName]);
            }
        }

        return $success;
    }
}