<?php

namespace App\Infrastructure\Config;

use App\Application\Config\Contract\GoogleSheetConfigContract;

class GoogleSheetEnvConfig implements GoogleSheetConfigContract
{
    public function getSheetCredentialsPath(): string
    {
        return $_ENV['GOOGLE_SHEETS_CREDENTIALS_PATH'] ?? '';
    }

    public function getSheetID(): string
    {
        return $_ENV['GOOGLE_SHEETS_ID'] ?? '';
    }

    public function getSheetTitle(): string
    {
        return $_ENV['GOOGLE_SHEETS_TITLE'] ?? '';

    }
    public function getUsedEnvConfigStatus(): bool
    {
        return $_ENV['USED_GOOGLE_ENV_CONFIG'] ?? '';

    }

}
