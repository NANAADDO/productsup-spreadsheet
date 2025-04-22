<?php

namespace App\Infrastructure\File\Save;

use App\Application\Config\Contract\FileSourceConfigContract;
use App\Application\File\Contract\FileSaverContract;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias(FileSaverContract::class)]
class XmlFileSaver implements FileSaverContract
{
    public function __construct(private FileSourceConfigContract $fileSourceConfig)
    {
    }

    public function save(string $content): void
    {
        $fullPath = $this->fileSourceConfig->getFilePath();

        if (!is_dir(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0775, true);
        }

        file_put_contents($fullPath, $content);

    }

}
