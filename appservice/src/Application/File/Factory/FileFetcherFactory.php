<?php

namespace App\Application\File\Factory;


use App\Application\Config\Contract\ExternalFeedSourceConfigContract;
use App\Application\File\Contract\FileFetcherContract;
use App\Domain\Exceptions\UnsupportedFileSourceException;
use App\Infrastructure\File\Fetch\RemoteXmlFetcher;
use App\Infrastructure\File\Fetch\LocalXmlFileFetcher;


class FileFetcherFactory
{
    public function __construct(private ExternalFeedSourceConfigContract $feedSourceYmlConfig){

    }

    public function create(string $FileSource): FileFetcherContract
    {

        return match (strtolower($FileSource)) {
            'local' => new LocalXmlFileFetcher(),
            'remote' => new RemoteXmlFetcher($this->feedSourceYmlConfig),
            default => throw new UnsupportedFileSourceException($FileSource),
        };
    }
}