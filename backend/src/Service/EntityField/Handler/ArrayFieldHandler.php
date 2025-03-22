<?php

namespace App\Service\EntityField\Handler;

use App\Service\EntityField\AbstractFieldHandler;
use App\Service\EntityField\FieldTypeDetector;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ArrayFieldHandler extends AbstractFieldHandler
{
    public function __construct(
        private readonly FieldTypeDetector $fieldTypeDetector
    ) {
    }

    public function supports(string $fieldType): bool
    {
        return in_array($fieldType, ['array', 'collection']);
    }

    /**
     * Проверяет, является ли поле массивом
     */
    public function isArrayField(object $entity, string $fieldName): bool
    {
        return $this->fieldTypeDetector->isArrayField($entity, $fieldName);
    }

    /**
     * Обрабатывает поля с массивами
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

            // Получаем значение
            $value = $data[$fieldName];

            // Проверяем, что значение действительно массив
            if (!is_array($value)) {
                if ($errors) {
                    $this->addError(
                        $entity,
                        $fieldName,
                        $errorMessage ?? ucfirst($fieldName) . ' must be an array',
                        $value,
                        $errors
                    );
                }
                $success = false;
                continue;
            }

            // Определяем методы для работы с массивом
            $singularName = rtrim($fieldName, 's');
            $adder = 'add' . ucfirst($singularName);

            // Если нет adder с удаленной 's', пробуем с полным именем
            if (!method_exists($entity, $adder)) {
                $adder = 'add' . ucfirst($fieldName);
            }

            $setter = 'set' . ucfirst($fieldName);
            $getter = 'get' . ucfirst($fieldName);
            $remover = 'remove' . ucfirst($singularName);

            if (!method_exists($entity, $remover)) {
                $remover = 'remove' . ucfirst($fieldName);
            }

            // Проверяем, есть ли прямой сеттер для массива
            if (method_exists($entity, $setter)) {
                $entity->$setter($value);
                continue;
            }

            // Если нет прямого сеттера, используем adder/remover
            if (method_exists($entity, $adder)) {
                // Очищаем существующие значения, если есть getter и remover
                if (method_exists($entity, $getter) && method_exists($entity, $remover)) {
                    $collection = $entity->$getter();

                    // Создаем копию коллекции
                    $itemsToRemove = [];
                    if ($collection !== null) {
                        foreach ($collection as $item) {
                            $itemsToRemove[] = $item;
                        }

                        // Удаляем все элементы
                        foreach ($itemsToRemove as $item) {
                            $entity->$remover($item);
                        }
                    }
                }

                // Добавляем новые элементы
                foreach ($value as $item) {
                    if ($item !== null) {
                        $entity->$adder($item);
                    }
                }
            } else {
                if ($errors) {
                    $this->addError(
                        $entity,
                        $fieldName,
                        "Cannot handle array field: no suitable setter or adder method found",
                        null,
                        $errors
                    );
                }
                $success = false;
            }
        }

        return $success;
    }
}