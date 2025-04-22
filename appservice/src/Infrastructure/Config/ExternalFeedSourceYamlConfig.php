<?php

namespace App\Infrastructure\Config;

use App\Application\Config\Contract\ExternalFeedSourceConfigContract;
use App\Application\Config\Contract\FileSourceConfigContract;
use App\Infrastructure\Config\constant\ConfigKeys;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\Yaml\Yaml;

#[AsAlias(ExternalFeedSourceConfigContract::class)]
class ExternalFeedSourceYamlConfig implements ExternalFeedSourceConfigContract
{
    private array $config;
    private mixed  $environment;

    public function __construct(private FileSourceConfigContract $fileSourceEnvConfig)
    {
        $this->config = Yaml::parseFile($this->fileSourceEnvConfig->getFileRemoteSecretPath());
        // refactor this line to  dynamically pick Env status
        $this->environment = ConfigKeys::DEV == 'dev';
    }

    public function getHost(): string
    {
        return $this->environment ? $this->config[ConfigKeys::FTP_DEV][ConfigKeys::URL] :
            $this->config[ConfigKeys::FTP_PROD][ConfigKeys::URL];

    }

    public function getPassword(): string
    {
        return $this->environment ? $this->config[ConfigKeys::FTP_DEV][ConfigKeys::PASS] :
            $this->config[ConfigKeys::FTP_PROD][ConfigKeys::PASS];

    }

    public function getUsername(): string
    {
        return $this->environment ? $this->config[ConfigKeys::FTP_DEV][ConfigKeys::USER] :
            $this->config[ConfigKeys::FTP_PROD][ConfigKeys::USER];

    }

}
