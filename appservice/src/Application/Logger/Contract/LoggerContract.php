<?php

namespace App\Application\Logger\Contract;

interface LoggerContract

{

    public function Info(string $message, array $context = []): void;

    public function Warning(string $message, array $context = []): void;

    public function Debug(string $message, array $context = []): void;

    public function Error(string $message, array $context = []): void;



}