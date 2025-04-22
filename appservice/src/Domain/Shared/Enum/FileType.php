<?php

namespace App\Domain\Shared\Enum;

enum FileType: string
{
    case XML = 'xml';
    case CSV = 'csv';
}
