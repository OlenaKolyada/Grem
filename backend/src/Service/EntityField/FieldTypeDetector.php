<?php

namespace App\Service\EntityField;

use Doctrine\Common\Collections\Collection;

class FieldTypeDetector
{
    /**
     * Определяет тип поля сущности
     *
     * @return string Тип поля: 'enum', 'date', 'collection', 'relation', 'array', 'basic'
     */
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

    /**
     * Определяет, является ли поле Enum
     */
    public function isEnumField(object $entity, string $fieldName): bool
    {
        return $this->getEnumType($entity, $fieldName) !== null;
    }

    /**
     * Получает класс Enum для поля сущности
     */
    public function getEnumType(object $entity, string $fieldName): ?string
    {
        try {
            $reflection = new \ReflectionClass($entity);

            if (!$reflection->hasProperty($fieldName)) {
                return null;
            }

            $property = $reflection->getProperty($fieldName);
            $type = $property->getType();

            if ($type && !$type->isBuiltin()) {
                $typeName = $type->getName();

                // Проверяем, является ли тип Enum
                if (\enum_exists($typeName)) {
                    return $typeName;
                }
            }
        } catch (\Exception $e) {
            // В случае ошибки просто возвращаем null
        }

        return null;
    }

    /**
     * Определяет, является ли поле типом DateTime
     */
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
            // В случае ошибки просто возвращаем false
        }

        return false;
    }

    /**
     * Определяет, является ли поле коллекцией (ManyToMany или OneToMany)
     */
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
                // Проверяем, является ли тип коллекцией
                return is_a($typeName, Collection::class, true) ||
                    strpos($typeName, 'Collection') !== false;
            }

            // Проверяем наличие методов для работы с коллекцией
            $singularName = rtrim($fieldName, 's');
            $adder = 'add' . ucfirst($singularName);
            $remover = 'remove' . ucfirst($singularName);

            return method_exists($entity, $adder) && method_exists($entity, $remover);
        } catch (\Exception $e) {
            // В случае ошибки просто возвращаем false
        }

        return false;
    }

    /**
     * Определяет, является ли поле отношением с другой сущностью (ManyToOne)
     */
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

                // Исключаем уже проверенные типы
                if (\enum_exists($typeName) ||
                    $typeName === \DateTime::class ||
                    $typeName === \DateTimeInterface::class ||
                    $typeName === \DateTimeImmutable::class) {
                    return false;
                }

                // Исключаем коллекции
                if (is_a($typeName, Collection::class, true) ||
                    strpos($typeName, 'Collection') !== false) {
                    return false;
                }

                // Предполагаем, что это отношение с сущностью, если тип не встроенный
                // и не относится к предыдущим категориям
                return true;
            }
        } catch (\Exception $e) {
            // В случае ошибки просто возвращаем false
        }

        return false;
    }

    /**
     * Определяет, является ли поле массивом
     */
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
                // Проверяем, является ли тип массивом
                return $typeName === 'array' || strpos($typeName, '[]') !== false;
            }

            // Проверяем наличие методов для работы с массивом
            $singularName = rtrim($fieldName, 's');
            $adder = 'add' . ucfirst($singularName);

            if (!method_exists($entity, $adder)) {
                $adder = 'add' . ucfirst($fieldName);
            }

            return method_exists($entity, $adder);
        } catch (\Exception $e) {
            // В случае ошибки просто возвращаем false
        }

        return false;
    }
}