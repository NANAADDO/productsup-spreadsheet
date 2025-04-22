<?php

namespace App\Infrastructure\GoogleDocument\Sheet;


use App\Application\GoogleDocument\Sheet\Contract\SheetWriterContract;
use Google_Service_Sheets;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias(SheetWriterContract::class)]
class SheetWriter implements SheetWriterContract
{
        public function __construct(private Google_Service_Sheets $sheetsService) {}

        public function write(string $spreadsheetId, string $range, array $data): void
    {
        $body = new \Google_Service_Sheets_ValueRange([
            'values' => $data
        ]);

        $params = ['valueInputOption' => 'RAW'];

        $this->sheetsService->spreadsheets_values->update($spreadsheetId, $range, $body, $params);
    }

}