<?php

namespace Tests\Unit;

use App\Support\PersianDate;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersianDateTest extends TestCase
{
    #[Test]
    public function it_formats_gregorian_to_jalali_for_display(): void
    {
        $date = Carbon::parse('2026-03-20');

        $this->assertSame('1404/12/29', PersianDate::format($date, 'Y/m/d'));
        $this->assertSame('1404/12/29', jalali($date));
    }

    #[Test]
    public function it_formats_datetime_to_jalali(): void
    {
        $date = Carbon::parse('2026-03-20 14:30:00');

        $this->assertSame('1404/12/29 14:30', PersianDate::formatDateTime($date));
        $this->assertSame('1404/12/29 14:30', jalali_datetime($date));
    }

    #[Test]
    public function it_converts_jalali_input_back_to_gregorian_for_storage(): void
    {
        $this->assertSame('2026-03-20', PersianDate::toGregorian('1404/12/29'));
        $this->assertSame('2026-03-20 14:30:00', PersianDate::toGregorian('1404/12/29 14:30', withTime: true));
    }

    #[Test]
    public function it_keeps_gregorian_input_as_gregorian_for_storage(): void
    {
        $this->assertSame('2026-03-20', PersianDate::toGregorian('2026-03-20'));
        $this->assertSame('2026-03-20 00:00:00', PersianDate::toGregorian(Carbon::parse('2026-03-20'), withTime: true));
    }

    #[Test]
    public function it_returns_null_for_empty_values(): void
    {
        $this->assertNull(PersianDate::format(null));
        $this->assertNull(PersianDate::toGregorian(null));
        $this->assertNull(jalali(null));
    }
}
