<?php

namespace App\Service\EntityField;

use Doctrine\Common\Collections\Collection;

class FieldTypeDetector
{
    public function detectFieldType(object $entity, string $fieldName): string
    {
        if ($this->isEnumField($entity, $fieldName)) {
            return 'enum';
        }

        if ($this->isDateField($entity, $fieldName)) {
            return 'date';
        }

        if ($this->isCollectionField($entity, $fieldName)) {
            return 'collection';
        }

        if ($this->isRelationField($entity, $fieldName)) {
            return 'relation';
        }

        if ($this->isArrayField($entity, $fieldName)) {
            return 'array';
        }

        return 'basic';
    }

    public function isEnumField(object $entity, string $fieldName): string|bool
    {
        try {
            $reflection = new \ReflectionClass($entity);

            if (!$reflection->hasProperty($fieldName)) {
                return false;
            }

            $property = $reflection->getProperty($fieldName);
            $type = $property->getType();

            if ($type && !$type->isBuiltin()) {
                $typeName = $type->getName();

                if (\enum_exists($typeName)) {
                    return $typeName;
                }
            }
        } catch (\Exception $e) {
        }

        return false;
    }

    public function isDateField(object $entity, string $fieldName): bool
    {
        try {
            $reflection = new \ReflectionClass($entity);

            if (!$reflection->hasProperty($fieldName)) {
                return false;
            }

            $property = $reflection->getProperty($fieldName);
            $type = $property->getType();

            if ($type) {
                $typeName = $type->getName();
                return $typeName === \DateTime::class ||
                    $typeName === \DateTimeInterface::class ||
                    $typeName === \DateTimeImmutable::class;
            }
        } catch (\Exception $e) {
        }

        return false;
    }

    public function isCollectionField(object $entity, string $fieldName): bool
    {
        try {
            $reflection = new \ReflectionClass($entity);

            if (!$reflection->hasProperty($fieldName)) {
                return false;
            }

            $property = $reflection->getProperty($fieldName);
            $type = $property->getType();

            if ($type) {
                $typeName = $type->getName();

                return is_a($typeName, Collection::class, true) ||
                    str_contains($typeName, 'Collection');
            }

            $singularName = rtrim($fieldName, 's');
            $adder = 'add' . ucfirst($singularName);
            $remover = 'remove' . ucfirst($singularName);

            return method_exists($entity, $adder) && method_exists($entity, $remover);
        } catch (\Exception $e) {
        }

        return false;
    }

    public function isRelationField(object $entity, string $fieldName): bool
    {
        try {
            $reflection = new \ReflectionClass($entity);

            if (!$reflection->hasProperty($fieldName)) {
                return false;
            }

            $property = $reflection->getProperty($fieldName);
            $type = $property->getType();

            if ($type && !$type->isBuiltin()) {
                $typeName = $type->getName();

                if (\enum_exists($typeName) ||
                    $typeName === \DateTime::class ||
                    $typeName === \DateTimeInterface::class ||
                    $typeName === \DateTimeImmutable::class) {
                    return false;
                }

                if (is_a($typeName, Collection::class, true) ||
                    str_contains($typeName, 'Collection')) {
                    return false;
                }

                return true;
            }
        } catch (\Exception $e) {
        }

        return false;
    }

    public function isArrayField(object $entity, string $fieldName): bool
    {
        try {
            $reflection = new \ReflectionClass($entity);

            if (!$reflection->hasProperty($fieldName)) {
                return false;
            }

            $property = $reflection->getProperty($fieldName);
            $type = $property->getType();

            if ($type) {
                $typeName = $type->getName();
                return $typeName === 'array' || str_contains($typeName, '[]');
            }

            $singularName = rtrim($fieldName, 's');
            $adder = 'add' . ucfirst($singularName);

            if (!method_exists($entity, $adder)) {
                $adder = 'add' . ucfirst($fieldName);
            }

            return method_exists($entity, $adder);
        } catch (\Exception $e) {
        }

        return false;
    }
}