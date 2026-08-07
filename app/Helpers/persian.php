<?php

use App\Support\PersianDate;

if (! function_exists('jalali')) {
    /**
     * Format a Gregorian date/datetime as Jalali for display.
     */
    function jalali(mixed $value, string $format = 'Y/m/d'): ?string
    {
        return PersianDate::format($value, $format);
    }
}

if (! function_exists('jalali_datetime')) {
    function jalali_datetime(mixed $value, string $format = 'Y/m/d H:i'): ?string
    {
        return PersianDate::formatDateTime($value, $format);
    }
}
