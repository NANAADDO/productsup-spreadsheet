<?php

namespace App\Domain\Exceptions;

use DomainException;

class UnsupportedFileSourceException extends DomainException
{
    public function __construct(string $message)
    {
        parent::__construct("Unsupported File Source:  '{$message}'");

    }

}
