<?php

namespace App\Application\GoogleDocument\Sheet\Contract;

interface SheetProcessContract
{
    /**
     * @param array<int, array<string, mixed>> $data
     */
    public function process(array $data): string;

}
