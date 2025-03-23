<?php

namespace App\Service\EntityField\Configuration;

interface EntityConfigurationFactoryInterface
{
    public function create(string $entityType): array;
}