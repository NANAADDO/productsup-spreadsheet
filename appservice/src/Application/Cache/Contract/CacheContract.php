<?php

namespace App\Application\Cache\Contract;

interface CacheContract
{
    /**
     *  @param mixed $cacheValue
     */
    public function setCacheData(string $cacheKey, mixed $cacheValue, int $cacheExpireTime): void;

    public function getCacheData(string $cacheName): mixed;

    public function setCacheToForget(string $cacheName): void;

    public function verifyCacheHasData(string $cacheName): bool;

}
