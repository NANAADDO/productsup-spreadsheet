<?php

namespace App\Shared\Util;

class SheetNameHelper
{
    public static function getSheetName(string $companyName, string $fileName): string
    {
        return sprintf('%s-%s-%s', $companyName, trim($fileName), DateHelper::getCurrentDate());
    }

    public static function getCurrentDate(string $format = 'Y-m-d', string $timezone = 'UTC'): string
    {
        return (new \DateTimeImmutable('now', new \DateTimeZone($timezone)))->format($format);
    }
}
