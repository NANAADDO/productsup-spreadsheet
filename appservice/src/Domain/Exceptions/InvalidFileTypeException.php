<?php

namespace App\Domain\Exceptions;

use DomainException;

class InvalidFileTypeException extends DomainException
{
    public function __construct(string $expected = '.xml')
    {
        parent::__construct("Invalid file type. Expected file extension: '{$expected}'");
    }
}
