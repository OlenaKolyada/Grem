<?php

namespace App\Service\EntityField;

use App\Service\EntityField\AbstractFieldHandler;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class EntityRelationFieldHandler extends AbstractFieldHandler
{
    public function supports(string $fieldType): bool
    {
        return in_array($fieldType, ['entity', 'relation', 'manytoone']);
    }

    /**
     * Обрабатывает поле, содержащее связь с другой сущностью
     *
     * @param object $entity Сущность, которую обновляем
     * @param array $data Данные запроса
     * @param string $fieldName Имя поля
     * @param object $repository Репозиторий для поиска связанной сущности
     * @param array $searchConfig Конфигурация поиска:
     *        - string|null numericField - поле для поиска, если значение числовое (например, 'id')
     *        - string|null stringField - поле для поиска, если значение строковое (например, 'nickname')
     *        - callable|null customFinder - пользовательская функция для поиска сущности
     * @param ConstraintViolationListInterface $errors Список ошибок
     * @param bool $isRequired Обязательное ли поле
     * @param string|null $errorMessage Сообщение об ошибке
     * @return bool Успешно ли обработано поле
     */
    public function handleEntityField(
        object $entity,
        array $data,
        string $fieldName,
        object $repository,
        array $searchConfig,
        ConstraintViolationListInterface $errors,
        bool $isRequired = false,
        string $errorMessage = null
    ): bool {
        // Если поле не указано и не обязательное - всё ок
        if (!isset($data[$fieldName]) && !$isRequired) {
            return true;
        }

        // Если поле не указано, но обязательное - ошибка
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

        // Ищем связанную сущность
        $relatedEntity = null;

        // Если предоставлена пользовательская функция поиска
        if (isset($searchConfig['customFinder']) && is_callable($searchConfig['customFinder'])) {
            $relatedEntity = $searchConfig['customFinder']($data[$fieldName]);
        }
        // Иначе используем стандартный поиск
        else {
            $numericField = $searchConfig['numericField'] ?? 'id';
            $stringField = $searchConfig['stringField'] ?? null;

            if (is_numeric($data[$fieldName]) && $numericField) {
                $relatedEntity = $repository->findOneBy([$numericField => $data[$fieldName]]);
            } elseif ($stringField) {
                $relatedEntity = $repository->findOneBy([$stringField => $data[$fieldName]]);
            }
        }

        // Если сущность не найдена и поле обязательное - ошибка
        if ($relatedEntity === null && $isRequired) {
            $this->addError(
                $entity,
                $fieldName,
                $errorMessage ?? ucfirst($fieldName) . ' entity not found',
                $data[$fieldName],
                $errors
            );
            return false;
        }

        // Если сущность найдена, устанавливаем её
        if ($relatedEntity !== null) {
            $setter = 'set' . ucfirst($fieldName);
            $entity->$setter($relatedEntity);
        }

        return true;
    }
}