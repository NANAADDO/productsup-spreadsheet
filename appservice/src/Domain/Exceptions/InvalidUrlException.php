<?php

namespace App\Domain\Exceptions;

use DomainException;

class InvalidUrlException extends DomainException
{
    public function __construct(string $url)
    {
        parent::__construct("Invalid URL provided: '{$url}'");

    }

}
