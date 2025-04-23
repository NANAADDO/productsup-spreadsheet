<?php

namespace App\Infrastructure\GoogleDocument\Sheet;

use App\Application\GoogleDocument\Sheet\Contract\GooglesheetAuthenticateContract;
use App\Application\GoogleDocument\Sheet\Contract\SheetCreatorContract;
use Google_Service_Sheets_Spreadsheet;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias(SheetCreatorContract::class)]
class SheetCreator implements SheetCreatorContract
{
    private $sheetsService;
    public function __construct(private GooglesheetAuthenticateContract $googlesheetAuthenticate)
    {
        $this->sheetsService = $this->googlesheetAuthenticate->authenticate('Create Sheet');
    }

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
