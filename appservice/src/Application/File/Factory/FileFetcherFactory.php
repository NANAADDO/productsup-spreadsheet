<?php

namespace App\Application\File\Factory;

use App\Application\Config\Contract\ExternalFeedSourceConfigContract;
use App\Application\File\Contract\FileFetcherContract;
use App\Application\Http\Contract\HttpClientContract;
use App\Domain\Exceptions\UnsupportedFileSourceException;
use App\Infrastructure\File\Fetch\LocalXmlFileFetcher;
use App\Infrastructure\File\Fetch\RemoteXmlFetcher;

class FileFetcherFactory
{
    public function __construct(
        private ExternalFeedSourceConfigContract $feedSourceYmlConfig,
        private HttpClientContract $httpClientContract
    ) {

    }

    public function create(string $FileSource): FileFetcherContract
    {

        return match (strtolower($FileSource)) {
            'local' => new LocalXmlFileFetcher(),
            'remote' => new RemoteXmlFetcher($this->feedSourceYmlConfig, $this->httpClientContract),
            default => throw new UnsupportedFileSourceException($FileSource),
        };
    }
}
