<?php

namespace App\Application\GoogleDocument\Sheet\Contract;

use Google_Service_Sheets;

interface GooglesheetAuthenticateContract
{
    public function authenticate(string $ApplicationName): Google_Service_Sheets;
}
