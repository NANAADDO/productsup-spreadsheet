<?php

namespace App\Infrastructure\GoogleDocument\Sheet;

use App\Application\Config\Contract\GoogleSheetConfigContract;
use App\Application\GoogleDocument\Sheet\Contract\GooglesheetAuthenticateContract;
use Google_Service_Sheets;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias(GooglesheetAuthenticateContract::class)]
class GooglesheetAuthenticate implements GooglesheetAuthenticateContract
{
    public function __construct(private GoogleSheetConfigContract $googleSheetConfig)
    {

    }
    public function authenticate(string $ApplicationName): Google_Service_Sheets
    {
        $client = new \Google_Client();
        $client->setAuthConfig($this->googleSheetConfig->getSheetCredentialsPath());
        $client->addScope(\Google_Service_Sheets::SPREADSHEETS);
        $client->setApplicationName($ApplicationName);

        return  new Google_Service_Sheets($client);

    }

}
