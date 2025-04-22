<?php

namespace App\Application\Logger\Contract;

interface LoggerContract
{
    /**
     * @param array<string, mixed> $context
     */
    public function Info(string $message, array $context = []): void;

    /**
     * @param array<string, mixed> $context
     */
    public function Warning(string $message, array $context = []): void;

    /**
     * @param array<string, mixed> $context
     */
    public function Debug(string $message, array $context = []): void;

    /**
     * @param array<string, mixed> $context
     */
    public function Error(string $message, array $context = []): void;

}
