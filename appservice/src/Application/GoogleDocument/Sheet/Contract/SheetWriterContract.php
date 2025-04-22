<?php

namespace App\Application\GoogleDocument\Sheet\Contract;
interface SheetWriterContract
{
    public function write(string $spreadsheetId, string $range, array $data): void;

}