<?php

namespace App\Application\Product\Contract;
/**
 * @template TEntity
 */
interface ProductFactoryContract
{
    /**
     * @param array $rawData
     * @return TEntity[]
     */
    public function createFromArray(array $rawData): array;

}