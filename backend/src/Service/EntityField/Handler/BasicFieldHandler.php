<?php

namespace App\Service\EntityField\Handler;

use App\Service\EntityField\FieldTypeDetector;
use App\Service\EntityField\FieldErrorHandler;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class BasicFieldHandler extends AbstractFieldHandler
{
    public function __construct(
        private readonly FieldTypeDetector $fieldTypeDetector,
        private readonly FieldErrorHandler $errorHandler
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
            // Пропускаем поля, если они не должны обрабатываться этим обработчиком
            if ($this->fieldTypeDetector->isDateField($entity, $fieldName) ||
                $this->fieldTypeDetector->isEnumField($entity, $fieldName) ||
                $this->fieldTypeDetector->isCollectionField($entity, $fieldName) ||
                $this->fieldTypeDetector->isRelationField($entity, $fieldName) ||
                $this->fieldTypeDetector->isArrayField($entity, $fieldName)) {
                continue;
            }

            // Проверяем обязательность поля
            $fieldValid = $this->validateRequiredField(
                $entity,
                $data,
                $fieldName,
                $this->errorHandler,
                $errors,
                $required,
                $errorMessage
            );

            if (!$fieldValid) {
                $success = false;
                continue;
            }

            // Устанавливаем значение поля
            $setter = 'set' . ucfirst($fieldName);
            if (method_exists($entity, $setter)) {
                $entity->$setter($data[$fieldName]);
            }
        }

        return $success;
    }
}