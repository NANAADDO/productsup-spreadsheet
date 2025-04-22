<?php

namespace App\Application\File\Contract;


use App\Application\Config\Contract\FileSourceConfigContract;
use SplFileInfo;

interface FileFetcherContract
{

    public function  fetch(FileSourceConfigContract $fileSourceEnvConfig): string;



}