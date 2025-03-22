<?php

namespace App\Service\EntityField;

use App\Service\EntityField\Handler\ArrayFieldHandler;
use App\Service\EntityField\Handler\BasicFieldHandler;
use App\Service\EntityField\Handler\CollectionFieldHandler;
use App\Service\EntityField\Handler\DateFieldHandler;
use App\Service\EntityField\Handler\EnumFieldHandler;
use App\Service\EntityField\Handler\RelationFieldHandler;
use Symfony\Component\Validator\ConstraintViolationListInterface;

readonly class FieldManager
{
    public function __construct(
        private BasicFieldHandler      $basicFieldHandler,
        private EnumFieldHandler       $enumFieldHandler,
        private RelationFieldHandler   $relationFieldHandler,
        private CollectionFieldHandler $collectionFieldHandler,
        private DateFieldHandler       $dateFieldHandler,
        private ArrayFieldHandler      $arrayFieldHandler,
        private FieldTypeDetector      $fieldTypeDetector
    ) {
    }

    public function handleFields(
        object $entity,
        array $data,
        array $fieldNames,
        ?ConstraintViolationListInterface $errors = null,
        bool $required = false,
        ?string $errorMessage = null
    ): bool {

        $dateFields = [];
        $enumFields = [];
        $relationFields = [];
        $collectionFields = [];
        $arrayFields = [];
        $basicFields = [];

        foreach ($fieldNames as $fieldName) {
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

        $success = true;

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

    public function handleRelationField(
        object $entity,
        array $data,
        string $fieldName,
        object $repository,
        array $searchConfig,
        ConstraintViolationListInterface $errors,
        bool $isRequired = false,
        ?string $errorMessage = null
    ): bool {
        return $this->relationFieldHandler->handleRelationField(
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