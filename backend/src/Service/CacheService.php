<?php

namespace App\Service;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

readonly class CacheService
{
    public function __construct(
        private SerializerInterface $serializer,
        private TagAwareCacheInterface $cache
    ) {
    }

    public function getCachedData(
        string $idCache,
        string $tag,
        callable $dataFetcher,
        string $serializationGroup = null,
        array $ignoredAttributes = [],
        int $expiration = 10
    ): string {
        return $this->cache->get(
            $idCache,
            function (ItemInterface $item) use (
                $tag,
                $dataFetcher,
                $serializationGroup,
                $ignoredAttributes,
                $expiration
            ) {
                $item->tag($tag);
                $item->expiresAfter($expiration);

                $data = $dataFetcher();

                $context = [];
                if ($serializationGroup) {
                    $context['groups'] = $serializationGroup;
                }
                if (!empty($ignoredAttributes)) {
                    $context['ignored_attributes'] = $ignoredAttributes;
                }

                return $this->serializer->serialize($data, 'json', $context);
            }
        );
    }
}