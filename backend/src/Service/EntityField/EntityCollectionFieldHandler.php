<?php

namespace App\Service\EntityField;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class EntityCollectionFieldHandler extends AbstractFieldHandler
{
    public function supports(string $fieldType): bool
    {
        return in_array($fieldType, ['collection', 'manytomany', 'onetomany']);
    }

    /**
     * Обрабатывает поле со связью ManyToMany или OneToMany
     *
     * @param object $entity Сущность
     * @param array $data Данные запроса
     * @param string $fieldName Имя поля
     * @param object $repository Репозиторий для поиска связанной сущности
     * @param array $searchConfig Конфигурация поиска (numericField, stringField)
     * @param ConstraintViolationListInterface $errors Список ошибок
     * @param bool $isRequired Обязательное ли поле
     * @param string|null $errorMessage Сообщение об ошибке
     * @param bool $clearExisting Нужно ли очищать существующую коллекцию
     * @return bool Успешно ли обработано поле
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
        // Если поля нет в данных и оно не обязательное - просто возвращаем true
        if (!isset($data[$fieldName]) && !$isRequired) {
            return true;
        }

        // Проверка обязательного поля
        if (!isset($data[$fieldName]) && $isRequired) {
            $this->addError(
                $entity,
                $fieldName,
                $errorMessage ?? ucfirst($fieldName) . ' is required',
                null,
                $errors
            );
            return false;
        }

        // Определяем методы для работы с коллекцией
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

        // Очищаем существующую коллекцию если нужно
        if ($clearExisting && method_exists($entity, $getter) && method_exists($entity, $remover)) {
            $collection = $entity->$getter();

            // Создаем копию коллекции, чтобы избежать проблем при итерации и удалении
            $itemsToRemove = [];
            foreach ($collection as $item) {
                $itemsToRemove[] = $item;
            }

            // Удаляем все элементы
            foreach ($itemsToRemove as $item) {
                $entity->$remover($item);
            }
        }

        // Получаем значения из запроса и обрабатываем различные форматы
        $values = $this->parseValues($data[$fieldName]);

        // Добавляем новые элементы
        foreach ($values as $value) {
            // Пропускаем пустые значения
            if (empty($value)) {
                continue;
            }

            // Ищем связанную сущность
            $relatedEntity = null;

            if (is_numeric($value) && isset($searchConfig['numericField'])) {
                $relatedEntity = $repository->findOneBy([$searchConfig['numericField'] => $value]);
            } elseif (isset($searchConfig['stringField'])) {
                $relatedEntity = $repository->findOneBy([$searchConfig['stringField'] => $value]);
            }

            // Проверяем найдена ли сущность
            if ($relatedEntity === null) {
                $this->addError(
                    $entity,
                    $fieldName,
                    $errorMessage ?? ucfirst($fieldName) . ' entity not found: ' . $value,
                    $value,
                    $errors
                );
                continue;
            }

            // Добавляем сущность в коллекцию
            $entity->$adder($relatedEntity);
        }

        return true;
    }

    /**
     * Разбирает значения различных форматов для коллекций
     *
     * @param mixed $value Значение из запроса
     * @return array Массив отдельных значений
     */
    private function parseValues(mixed $value): array
    {
        // Если значение уже массив
        if (is_array($value)) {
            return $value;
        }

        // Если значение строка, проверяем различные разделители
        if (is_string($value)) {
            // Проверяем запятую с пробелом
            if (str_contains($value, ', ')) {
                return array_map('trim', explode(', ', $value));
            }

            // Проверяем только запятую
            if (str_contains($value, ',')) {
                return array_map('trim', explode(',', $value));
            }

            // Проверяем точку с запятой
            if (str_contains($value, ';')) {
                return array_map('trim', explode(';', $value));
            }

            // Проверяем пробел
            if (str_contains($value, ' ')) {
                return array_map('trim', explode(' ', $value));
            }
        }

        // Если никакие разделители не найдены или значение не строка
        return [$value];
    }
}