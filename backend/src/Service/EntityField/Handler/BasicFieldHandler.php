<?php

namespace App\Service\EntityField\Handler;

use App\Service\EntityField\AbstractFieldHandler;
use App\Service\EntityField\FieldTypeDetector;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class BasicFieldHandler extends AbstractFieldHandler
{
    public function __construct(
        private readonly FieldTypeDetector $fieldTypeDetector
    ) {
    }

    public function supports(string $fieldType): bool
    {
        return in_array($fieldType, ['string', 'text', 'basic']);
    }

    /**
     * Обрабатывает поля
     */
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

            // Проверка для обязательных полей
            if ($required && !isset($data[$fieldName])) {
                if ($errors) {
                    $this->addError(
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

            // Пропускаем необязательные поля, если их нет в данных
            if (!$required && !isset($data[$fieldName])) {
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