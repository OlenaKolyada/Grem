<?php

namespace App\Service\EntityField\Handler;

use App\Service\EntityField\FieldErrorHandler;
use App\Service\EntityField\FieldTypeDetector;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class CollectionFieldHandler extends AbstractFieldHandler
{
    public function __construct(
        private readonly FieldTypeDetector $fieldTypeDetector,
        private readonly FieldErrorHandler $errorHandler
    ) {
    }

    // ManyToMany or OneToMany

    public function supports(string $fieldType): bool
    {
        return in_array($fieldType, ['collection', 'manytomany', 'onetomany']);
    }

    public function isCollectionField(object $entity, string $fieldName): bool
    {
        return $this->fieldTypeDetector->isCollectionField($entity, $fieldName);
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

        $singularName = rtrim($fieldName, 's');
        $adder = 'add' . ucfirst($singularName);
        if (!method_exists($entity, $adder)) {
            $adder = 'add' . ucfirst($fieldName);
        }

        $remover = 'remove' . ucfirst($singularName);
        if (!method_exists($entity, $remover)) {
            $remover = 'remove' . ucfirst($fieldName);
        }

        $getter = 'get' . ucfirst($fieldName);

        if ($clearExisting && method_exists($entity, $getter) && method_exists($entity, $remover)) {
            $collection = $entity->$getter();

            $itemsToRemove = [];
            foreach ($collection as $item) {
                $itemsToRemove[] = $item;
            }

            foreach ($itemsToRemove as $item) {
                $entity->$remover($item);
            }
        }

        $values = $this->parseValues($data[$fieldName]);

        foreach ($values as $value) {

            if (empty($value)) {
                continue;
            }

            $relatedEntity = null;

            if (is_numeric($value) && isset($searchConfig['numericField'])) {
                $relatedEntity = $repository->findOneBy([$searchConfig['numericField'] => $value]);
            } elseif (isset($searchConfig['stringField'])) {
                $relatedEntity = $repository->findOneBy([$searchConfig['stringField'] => $value]);
            }

            if ($relatedEntity === null) {
                $this->errorHandler->addError(
                    $entity,
                    $fieldName,
                    $errorMessage ?? ucfirst($fieldName) . ' entity not found: ' . $value,
                    $value,
                    $errors
                );
                continue;
            }

            $entity->$adder($relatedEntity);
        }

        return true;
    }

    private function parseValues(mixed $value): array
    {
        if (is_array($value)) {
            return $value;
        }

        return [$value];
    }
}