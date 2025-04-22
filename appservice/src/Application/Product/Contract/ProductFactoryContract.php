<?php

namespace App\Application\Product\Contract;

/**
 * @template TEntity
 */
interface ProductFactoryContract
{
    /**
     * @param array{name: string, price: float, sku: string} $rawData
     * @return TEntity[]
     */
    public function createFromArray(array $rawData): array;

}
