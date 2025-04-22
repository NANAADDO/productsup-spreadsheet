<?php

namespace App\Infrastructure\Config;

use App\Application\Config\Contract\FileSourceConfigContract;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias(FileSourceConfigContract::class)]
class FileSourceEnvConfig implements FileSourceConfigContract
{
    public function getFileSource(): string
    {
        return $_ENV['FILE_SOURCE'] ?? 'Local';
    }

    public function getFileName(): string
    {
        return $_ENV['FILE_NAME'] ?? 'coffee_feed';
    }

    public function getFilePath(): string
    {
        return sprintf('%s/%s/%s', $_ENV['FILE_PATH'], $_ENV['CLIENT_NAME'], $_ENV['FILE_NAME'])
            ?? 'storage/feeds/products';
    }

    public function getClientName(): string
    {
        return $_ENV['CLIENT_NAME'] ?? 'productsup';
    }
    public function getFileRemoteConnectionType(): string
    {
        return $_ENV['FILE_REMOTE_CONNECTION_TYPE'] ?? 'FTP';
    }
    public function getFileRemoteSecretPath(): string
    {
        return $_ENV['FILE_REMOTE_SECRET_YML_DIRECTORY'] ?? '';
    }
}
