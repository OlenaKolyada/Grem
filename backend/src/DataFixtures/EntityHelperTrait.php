<?php

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;
use Random\RandomException;

trait EntityHelperTrait
{

    protected function addRandomEntities(ObjectManager $manager, object $entity, array $entityTypes): void
    {
        foreach ($entityTypes as $entityType) {

            $availableReferences = [];
            $index = 0;
            while ($this->hasReference($entityType . '_' . $index)) {
                $availableReferences[] = $entityType . '_' . $index;
                $index++;
            }

            if (empty($availableReferences)) {
                throw new \RuntimeException("No references found for entity type: $entityType");
            }

            $numOfEntities = random_int(1, min(3, count($availableReferences)));

            shuffle($availableReferences);
            $selectedReferences = array_slice($availableReferences, 0, $numOfEntities);

            $method = 'add' . ucfirst($entityType);
            if (!method_exists($entity, $method)) {
                throw new \RuntimeException("Method $method does not exist on entity " . get_class($entity));
            }

            foreach ($selectedReferences as $reference) {
                try {
                    $randomEntity = $this->getReference($reference);
                    $entity->$method($randomEntity);
                } catch (\Exception $e) {
                    throw new \RuntimeException(
                        "Error adding $entityType reference $reference: " . $e->getMessage()
                    );
                }
            }
        }
    }
}