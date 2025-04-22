<?php

namespace App\Application\GoogleDocument\Sheet\Contract;

interface SheetWriterContract
{
    /**
     * @param list<list<string|int|float|null>> $data
     */
    public function write(string $spreadsheetId, string $range, array $data): void;

}
