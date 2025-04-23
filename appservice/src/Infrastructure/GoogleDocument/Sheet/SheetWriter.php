<?php

namespace App\Infrastructure\GoogleDocument\Sheet;

use App\Application\GoogleDocument\Sheet\Contract\GooglesheetAuthenticateContract;
use App\Application\GoogleDocument\Sheet\Contract\SheetWriterContract;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias(SheetWriterContract::class)]
class SheetWriter implements SheetWriterContract
{
    private $sheetsService;

    public function __construct(private GooglesheetAuthenticateContract $googlesheetAuthenticate)
    {
        $this->sheetsService = $this->googlesheetAuthenticate->authenticate(
            'push data to google spread sheet'
        );
    }

    public function write(string $spreadsheetId, string $range, array $data): void
    {
        $body = new \Google_Service_Sheets_ValueRange([
            'values' => $data
        ]);

        $params = ['valueInputOption' => 'RAW'];

        $this->sheetsService->spreadsheets_values->update($spreadsheetId, $range, $body, $params);
    }

}
