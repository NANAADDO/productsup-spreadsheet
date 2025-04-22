<?php

namespace App\Domain\Exceptions;

use DomainException;

class NotFoundException extends DomainException
{
    public function __construct()
    {
        parent::__construct('File does not exist or is not a regular file');
    }

}
