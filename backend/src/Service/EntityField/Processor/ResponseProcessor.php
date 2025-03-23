<?php

namespace App\Service\EntityField\Processor;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

readonly class ResponseProcessor
{
    public function __construct(
        private SerializerInterface $serializer
    ) {
    }

    public function createSuccessResponse(object $entity, string $group, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        $jsonData = $this->serializer->serialize(
            $entity,
            'json',
            [
                'groups' => $group,
                'ignored_attributes' => [strtolower(basename(get_class($entity)))]
            ]
        );

        return new JsonResponse(
            $jsonData,
            $statusCode,
            [],
            true
        );
    }
}