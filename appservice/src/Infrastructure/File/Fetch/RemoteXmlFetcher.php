<?php

namespace App\Infrastructure\File\Fetch;

use App\Application\Config\Contract\ExternalFeedSourceConfigContract;
use App\Application\Config\Contract\FileSourceConfigContract;
use App\Application\File\Contract\FileFetcherContract;
use App\Application\Http\Contract\HttpClientContract;

class RemoteXmlFetcher implements FileFetcherContract
{
    public function __construct(
        private ExternalFeedSourceConfigContract $feedSourceYmlConfig,
        private HttpClientContract  $curlClient
    ) {
    }
    public function fetch(FileSourceConfigContract $fileSourceEnvConfig): string
    {

        $url = $this->feedSourceYmlConfig->getHost().'/'.$fileSourceEnvConfig->getFileName();
        $username = $this->feedSourceYmlConfig->getUsername();
        $password = $this->feedSourceYmlConfig->getPassword();

        return $this->curlClient->get($url, $username, $password);
    }

}
