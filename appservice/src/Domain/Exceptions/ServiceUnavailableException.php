<?php

namespace App\Domain\Exceptions;

use DomainException;

class ServiceUnavailableException extends DomainException
{
    public function __construct(string $message)
    {
        parent::__construct("Service Unavailable '{$message}'");

    }

}
