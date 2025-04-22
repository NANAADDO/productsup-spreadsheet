<?php

namespace App\Shared\Util;

class DateHelper
{
    public static function formatDate(\DateTimeInterface $date, string $format = 'Y-m-d'): string
    {
        return $date->format($format);
    }

    public static function getCurrentDate(string $format = 'Y-m-d', string $timezone = 'UTC'): string
    {
        return (new \DateTimeImmutable('now', new \DateTimeZone($timezone)))->format($format);
    }
}
