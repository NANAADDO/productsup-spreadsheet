<?php

namespace App\Infrastructure\Cache;

use App\Application\Cache\Contract\CacheContract;
use Predis\Client;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias(CacheContract::class)]
class RedisCache implements CacheContract
{
    protected Client $cacheClient;

    public function __construct(Client $cacheClient)
    {
        $this->cacheClient = $cacheClient;
    }

    public function setCacheData(string $cacheKey, mixed $cacheValue, int $cacheExpireTime = 600): void
    {
        $this->cacheClient->setex($cacheKey, $cacheExpireTime, json_encode($cacheValue, true));

    }

    public function getCacheData(string $cacheName): mixed
    {
        return $this->cacheClient->get($cacheName);
    }

    public function setCacheToForget(string $cacheName): void
    {

    }

    public function verifyCacheHasData(string $cacheName): bool
    {
        return (bool)$this->cacheClient->exists($cacheName);

    }

    public function processCacheResponse(string $cacheKey): array
    {
        if ($this->verifyCacheHasData($cacheKey)) {
            return  ['hasKey' => true, $this->getCacheData($cacheKey)];
        }

        return ['hasKey' => false];

    }

}
