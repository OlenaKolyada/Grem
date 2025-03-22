<?php

namespace App\Service\EntityField;

use App\Service\EntityField\Handler\ArrayFieldHandler;
use App\Service\EntityField\Handler\BasicFieldHandler;
use App\Service\EntityField\Handler\CollectionFieldHandler;
use App\Service\EntityField\Handler\DateFieldHandler;
use App\Service\EntityField\Handler\EnumFieldHandler;
use App\Service\EntityField\Handler\RelationFieldHandler;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class FieldManager
{
    public function __construct(
        private readonly BasicFieldHandler      $basicFieldHandler,
        private readonly EnumFieldHandler       $enumFieldHandler,
        private readonly RelationFieldHandler   $relationFieldHandler,
        private readonly CollectionFieldHandler $collectionFieldHandler,
        private readonly DateFieldHandler       $dateFieldHandler,
        private readonly ArrayFieldHandler      $arrayFieldHandler,
        private readonly FieldTypeDetector      $fieldTypeDetector
    ) {
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
        // Разделяем поля по типам
        $dateFields = [];
        $enumFields = [];
        $relationFields = [];
        $collectionFields = [];
        $arrayFields = [];
        $basicFields = [];

        foreach ($fieldNames as $fieldName) {
            // Пробуем получить enum тип напрямую - это наиболее приоритетная проверка
            $enumClass = $this->fieldTypeDetector->isEnumField($entity, $fieldName);
            if ($enumClass) {
                $enumFields[] = $fieldName;
                continue;
            }

            if ($this->fieldTypeDetector->isDateField($entity, $fieldName)) {
                $dateFields[] = $fieldName;
            } elseif ($this->fieldTypeDetector->isArrayField($entity, $fieldName)) {
                $arrayFields[] = $fieldName;
            } elseif ($this->fieldTypeDetector->isCollectionField($entity, $fieldName)) {
                $collectionFields[] = $fieldName;
            } elseif ($this->fieldTypeDetector->isRelationField($entity, $fieldName)) {
                $relationFields[] = $fieldName;
            } else {
                $basicFields[] = $fieldName;
            }
        }

        // Обрабатываем каждый тип полей соответствующим обработчиком
        $success = true;

        // Обрабатываем поля с enum
        if (!empty($enumFields)) {
            $enumResult = $this->enumFieldHandler->handleFields(
                $entity,
                $data,
                $enumFields,
                $errors,
                $required,
                $errorMessage
            );
            $success = $success && $enumResult;
        }

        // Обрабатываем поля с датами
        if (!empty($dateFields)) {
            $dateResult = $this->dateFieldHandler->handleFields(
                $entity,
                $data,
                $dateFields,
                $errors,
                $required,
                $errorMessage
            );
            $success = $success && $dateResult;
        }

        // Обрабатываем поля с массивами
        if (!empty($arrayFields)) {
            $arrayResult = $this->arrayFieldHandler->handleFields(
                $entity,
                $data,
                $arrayFields,
                $errors,
                $required,
                $errorMessage
            );
            $success = $success && $arrayResult;
        }

        // Обрабатываем остальные поля
        if (!empty($basicFields)) {
            $basicResult = $this->basicFieldHandler->handleFields(
                $entity,
                $data,
                $basicFields,
                $errors,
                $required,
                $errorMessage
            );
            $success = $success && $basicResult;
        }

        return $success;
    }

    /**
     * Обрабатывает enum поле
     */
    public function handleEnumField(
        object $entity,
        array $data,
        string $fieldName,
        string $enumClass,
        ConstraintViolationListInterface $errors,
        bool $isRequired = true,
        ?string $errorMessage = null
    ): bool {
        return $this->enumFieldHandler->handleEnumField(
            $entity,
            $data,
            $fieldName,
            $enumClass,
            $errors,
            $isRequired,
            $errorMessage
        );
    }

    /**
     * Обрабатывает поле связи с сущностью
     */
    public function handleEntityField(
        object $entity,
        array $data,
        string $fieldName,
        object $repository,
        array $searchConfig,
        ConstraintViolationListInterface $errors,
        bool $isRequired = false,
        ?string $errorMessage = null
    ): bool {
        return $this->relationFieldHandler->handleEntityField(
            $entity,
            $data,
            $fieldName,
            $repository,
            $searchConfig,
            $errors,
            $isRequired,
            $errorMessage
        );
    }

    /**
     * Обрабатывает поле со связью ManyToMany или OneToMany
     */
    public function handleCollectionField(
        object $entity,
        array $data,
        string $fieldName,
        object $repository,
        array $searchConfig,
        ConstraintViolationListInterface $errors,
        bool $isRequired = false,
        ?string $errorMessage = null,
        bool $clearExisting = true
    ): bool {
        return $this->collectionFieldHandler->handleCollectionField(
            $entity,
            $data,
            $fieldName,
            $repository,
            $searchConfig,
            $errors,
            $isRequired,
            $errorMessage,
            $clearExisting
        );
    }

    /**
     * Обрабатывает поля типа дата
     */
    public function handleDateFields(
        object $entity,
        array $data,
        array $fieldNames,
        ?ConstraintViolationListInterface $errors = null,
        bool $required = false,
        ?string $errorMessage = null
    ): bool {
        return $this->dateFieldHandler->handleFields(
            $entity,
            $data,
            $fieldNames,
            $errors,
            $required,
            $errorMessage
        );
    }
}