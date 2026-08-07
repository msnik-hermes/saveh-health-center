<?php

namespace App\Providers;

use App\Support\PersianDate;
use Carbon\Carbon;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\ServiceProvider;

class PersianDateServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Carbon::macro('toJalali', function (string $format = 'Y/m/d'): string {
            /** @var Carbon $this */
            return PersianDate::format($this, $format) ?? '';
        });

        // Filament tables: Gregorian DB value -> Jalali display
        TextColumn::macro('jalaliDate', function (string $format = 'Y/m/d'): TextColumn {
            /** @var TextColumn $this */
            return $this
                ->formatStateUsing(fn ($state) => PersianDate::format($state, $format))
                ->placeholder('—');
        });

        TextColumn::macro('jalaliDateTime', function (string $format = 'Y/m/d H:i'): TextColumn {
            /** @var TextColumn $this */
            return $this
                ->formatStateUsing(fn ($state) => PersianDate::formatDateTime($state, $format))
                ->placeholder('—');
        });
    }
}
