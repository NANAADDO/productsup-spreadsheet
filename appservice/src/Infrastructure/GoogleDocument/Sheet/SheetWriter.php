<?php

namespace App\Infrastructure\GoogleDocument\Sheet;

use App\Application\Config\Contract\GoogleSheetConfigContract;
use App\Application\GoogleDocument\Sheet\Contract\SheetWriterContract;
use Google_Service_Sheets;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias(SheetWriterContract::class)]
class SheetWriter implements SheetWriterContract
{
    private $sheetsService;
    public function __construct(private GoogleSheetConfigContract $googleSheetConfig)
    {
        $client = new \Google_Client();
        $client->setAuthConfig($this->googleSheetConfig->getSheetCredentialsPath());
        $client->addScope(\Google_Service_Sheets::SPREADSHEETS);
        $client->setApplicationName('push data to google spread sheet');

        $this->sheetsService = new Google_Service_Sheets($client);
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
