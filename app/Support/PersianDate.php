<?php

namespace App\Support;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use DateTimeInterface;
use Morilog\Jalali\Jalalian;
use Throwable;

/**
 * Display-layer Jalali (Shamsi) conversion.
 * Database remains Gregorian; only UI/API presentation is converted.
 */
class PersianDate
{
    public static function format(mixed $value, string $format = 'Y/m/d'): ?string
    {
        $carbon = self::toCarbon($value);
        if (! $carbon) {
            return null;
        }

        try {
            return Jalalian::fromCarbon($carbon)->format($format);
        } catch (Throwable) {
            return null;
        }
    }

    public static function formatDateTime(mixed $value, string $format = 'Y/m/d H:i'): ?string
    {
        return self::format($value, $format);
    }

    /**
     * Convert Gregorian (Carbon/string) to Jalali string for display.
     */
    public static function toJalali(mixed $value, string $format = 'Y/m/d'): ?string
    {
        return self::format($value, $format);
    }

    /**
     * Convert Jalali input string to Gregorian Y-m-d (or Y-m-d H:i:s) for DB storage.
     */
    public static function toGregorian(mixed $value, bool $withTime = false): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        // Already a Carbon/DateTime from native pickers
        if ($value instanceof DateTimeInterface) {
            $carbon = Carbon::instance($value);

            return $withTime
                ? $carbon->format('Y-m-d H:i:s')
                : $carbon->format('Y-m-d');
        }

        $raw = trim((string) $value);
        $raw = str_replace(['-', '_', '.'], '/', $raw);

        // If already looks Gregorian (year > 1600), keep as-is normalized
        if (preg_match('/^(1[6-9]\d{2}|20\d{2}|21\d{2})\//', $raw)) {
            $carbon = self::toCarbon($raw);

            return $carbon
                ? ($withTime ? $carbon->format('Y-m-d H:i:s') : $carbon->format('Y-m-d'))
                : null;
        }

        try {
            $format = $withTime
                ? (strlen($raw) <= 10 ? 'Y/m/d' : (substr_count($raw, ':') === 1 ? 'Y/m/d H:i' : 'Y/m/d H:i:s'))
                : 'Y/m/d';

            // Date-only Jalali
            if (! $withTime || strlen($raw) <= 10) {
                $j = Jalalian::fromFormat('Y/m/d', substr($raw, 0, 10));
                $carbon = $j->toCarbon();

                return $withTime
                    ? $carbon->startOfDay()->format('Y-m-d H:i:s')
                    : $carbon->format('Y-m-d');
            }

            $j = Jalalian::fromFormat($format, $raw);

            return $j->toCarbon()->format('Y-m-d H:i:s');
        } catch (Throwable) {
            // Fallback: let Carbon try Gregorian parse
            $carbon = self::toCarbon($value);

            return $carbon
                ? ($withTime ? $carbon->format('Y-m-d H:i:s') : $carbon->format('Y-m-d'))
                : null;
        }
    }

    public static function toCarbon(mixed $value): ?CarbonInterface
    {
        if ($value === null || $value === '') {
            return null;
        }

        if ($value instanceof CarbonInterface) {
            return $value;
        }

        if ($value instanceof DateTimeInterface) {
            return Carbon::instance($value);
        }

        try {
            return Carbon::parse((string) $value);
        } catch (Throwable) {
            return null;
        }
    }
}
