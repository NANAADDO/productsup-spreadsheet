<?php

namespace App\Infrastructure\File\Fetch;

use App\Application\Config\Contract\FileSourceConfigContract;
use App\Application\File\Contract\LocalFileFetcherContract;
use App\Domain\Exceptions\FileNotAccessibleException;
use App\Domain\Exceptions\InvalidFileTypeException;
use App\Domain\Exceptions\NotFoundException;
use App\Domain\Shared\Enum\FileType;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias(LocalFileFetcherContract::class)]
class LocalXmlFileFetcher implements LocalFileFetcherContract
{
    public function fetch(FileSourceConfigContract $fileSourceEnvConfig): string
    {
        $fileInfo = new \SplFileInfo($fileSourceEnvConfig->getFilePath());

        if (! $fileInfo->isFile()) {
            throw new NotFoundException();
        }

        if (! $fileInfo->isReadable()) {
            throw new FileNotAccessibleException();
        }

        if (strtolower($fileInfo->getExtension()) != FileType::XML->value) {
            throw new InvalidFileTypeException($fileInfo->getExtension());
        }

        return file_get_contents($fileInfo->getRealPath());
    }

}
