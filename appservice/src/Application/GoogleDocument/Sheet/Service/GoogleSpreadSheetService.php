<?php

namespace App\Application\GoogleDocument\Sheet\Service;

use App\Application\GoogleDocument\Sheet\Contract\GoogleSpreadsheetContract;

class GoogleSpreadSheetService
{
    public function __construct(
        private GoogleSpreadsheetContract $googleSpreadSheet
    ) {

    }

    /**
     * @param list<array<string, string|int|float|null>> $data
     */
    public function processDataAndWriteToSheet(array $data): string
    {
        return $this->googleSpreadSheet->process($data);
    }

}
