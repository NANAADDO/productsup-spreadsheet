<?php

namespace App\Application\Config\Contract;

interface GoogleSheetConfigContract
{
    public function getSheetID(): string;
    public function getSheetCredentialsPath(): string;
    public function getSheetTitle(): string;
    public function getUsedEnvConfigStatus(): bool;

}
