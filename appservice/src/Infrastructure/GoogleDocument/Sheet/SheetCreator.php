<?php

namespace App\Infrastructure\GoogleDocument\Sheet;

use App\Application\GoogleDocument\Sheet\Contract\SheetCreatrContract;
use Google_Service_Sheets;
use Google_Service_Sheets_Spreadsheet;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias(SheetCreatrContract::class)]
class SheetCreator implements SheetCreatrContract
{
    public function __construct(private Google_Service_Sheets $sheetsService) {}

    public function create(string $title): string
    {
        $spreadsheet = new Google_Service_Sheets_Spreadsheet([
            'properties' => ['title' => $title]
        ]);

        return $this->sheetsService->spreadsheets->create($spreadsheet, [
            'fields' => 'spreadsheetId'
        ])->spreadsheetId;
    }
}
