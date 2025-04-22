<?php

namespace App\Domain\Exceptions;

use DomainException;

class FileNotAccessibleException extends DomainException
{
    public function __construct(string $url = '')
    {
        parent::__construct("Cannot access  file: '{$url}'");
    }
}
