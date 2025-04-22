<?php

namespace App\Application\File\Contract;

use App\Application\Config\Contract\FileSourceConfigContract;

interface FileFetcherContract
{
    public function fetch(FileSourceConfigContract $fileSourceEnvConfig): string;

}
