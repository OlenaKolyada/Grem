<?php

namespace App\Service\EntityField;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class EntityFieldManager
{
    public function __construct(
        private BasicFieldHandler $basicFieldHandler,
        private EnumFieldHandler $enumFieldHandler,
        private EntityRelationFieldHandler $entityRelationFieldHandler,
        private EntityCollectionFieldHandler $entityCollectionFieldHandler,
        private DateFieldHandler $dateFieldHandler
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
        $basicFields = [];

        foreach ($fieldNames as $fieldName) {
            if ($this->dateFieldHandler->isDateField($entity, $fieldName)) {
                $dateFields[] = $fieldName;
            } else {
                $basicFields[] = $fieldName;
            }
        }

        // Обрабатываем поля с датами
        $dateResult = true;
        if (!empty($dateFields)) {
            $dateResult = $this->dateFieldHandler->handleFields(
                $entity,
                $data,
                $dateFields,
                $errors,
                $required,
                $errorMessage
            );
        }

        // Обрабатываем остальные поля
        $basicResult = true;
        if (!empty($basicFields)) {
            $basicResult = $this->basicFieldHandler->handleFields(
                $entity,
                $data,
                $basicFields,
                $errors,
                $required,
                $errorMessage
            );
        }

        return $dateResult && $basicResult;
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
        return $this->enumFieldHandler->handleEnumField($entity, $data, $fieldName, $enumClass, $errors, $isRequired, $errorMessage);
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
        return $this->entityRelationFieldHandler->handleEntityField($entity, $data, $fieldName, $repository, $searchConfig, $errors, $isRequired, $errorMessage);
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
        return $this->entityCollectionFieldHandler->handleCollectionField(
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
        return $this->dateFieldHandler->handleFields($entity, $data, $fieldNames, $errors, $required, $errorMessage);
    }
}