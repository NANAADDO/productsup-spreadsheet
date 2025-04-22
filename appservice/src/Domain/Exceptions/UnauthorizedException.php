<?php

namespace App\Domain\Exceptions;

use DomainException;

class UnauthorizedException extends DomainException
{
    public function __construct(string $message)
    {
        parent::__construct("Unauthorized:  '{$message}'");

    }

}
