<?php

namespace App\Application\Config\Contract;

interface FileSourceConfigContract
{
    public function getFileSource(): string;

    public function getFileName(): string;

    public function getFilePath(): string;

    public function getClientName(): string;
    public function getFileRemoteConnectionType(): string;

    public function getFileRemoteSecretPath(): string;
}
