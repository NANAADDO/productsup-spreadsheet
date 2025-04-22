<?php

namespace App\Domain\Exceptions;

use DomainException;

class FileTooLargeException extends DomainException
{
    public function __construct(int $sizeLimit)
    {
        parent::__construct("Remote file exceeds the size limit of {$sizeLimit} bytes.");
    }
}
