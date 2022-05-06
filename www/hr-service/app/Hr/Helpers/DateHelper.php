<?php

namespace App\Hr\Helpers;

use Carbon\Carbon;

final class DateHelper
{
    public static function convertToTimestamp(?string $dateString, string $format = 'Y-m-d'): ?int
    {
        return $dateString ? Carbon::createFromFormat($format, $dateString)->timestamp : null;
    }
}
