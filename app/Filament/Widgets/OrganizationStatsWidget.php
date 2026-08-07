<?php

namespace App\Filament\Widgets;

use App\Models\Center;
use App\Models\Company;
use App\Models\Employee;
use App\Models\FacilityRequest;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrganizationStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('مراکز', (string) Center::query()->count())
                ->description('کل مراکز ثبت‌شده')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('success'),
            Stat::make('کارکنان', (string) Employee::query()->count())
                ->description('پرسنل شبکه')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
            Stat::make('شرکت‌ها', (string) Company::query()->count())
                ->description('واحدهای تحت پوشش')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('warning'),
            Stat::make('درخواست تاسیسات', (string) FacilityRequest::query()->count())
                ->description('کل درخواست‌ها')
                ->descriptionIcon('heroicon-m-wrench-screwdriver')
                ->color('gray'),
        ];
    }
}
