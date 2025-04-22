<?php

namespace App\Infrastructure\Logger;

use App\Application\Logger\Contract\LoggerContract;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias(LoggerContract::class)]
class MonoLogger implements LoggerContract
{
    public function __construct(private readonly LoggerInterface $monoLogger)
    {
    }

    public function Info(string $message, array $context = []): void
    {
        $this->monoLogger->info($message, $context);

    }
    public function Debug(string $message, array $context = []): void
    {
        $this->monoLogger->debug($message, $context);
    }
    public function Error(string $message, array $context = []): void
    {
        $this->monoLogger->error($message, $context);
    }
    public function Warning(string $message, array $context = []): void
    {
        $this->monoLogger->error($message, $context);
    }

}
