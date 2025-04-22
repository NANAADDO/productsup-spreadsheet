<?php

namespace App\Domain\Exceptions;

use DomainException;

class MalformedXmlException extends DomainException
{
    public function __construct(string $message = '')
    {
        parent::__construct("malformed XML Data  '{$message}'");

    }

}
