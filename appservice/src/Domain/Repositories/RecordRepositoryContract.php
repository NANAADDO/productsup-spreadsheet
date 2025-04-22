<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Products;

interface RecordRepositoryContract
{
    /**
     * @return Products[]
     */
    public function getRecord(string $source): array;

}