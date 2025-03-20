<?php

namespace App\Repository;

/**
 * Интерфейс для репозиториев, которые могут находить последние элементы
 */
interface LatestEntityInterface
{
    /**
     * Находит последний опубликованный элемент
     *
     * @return object|null
     */
    public function findLatest(): ?object;
}