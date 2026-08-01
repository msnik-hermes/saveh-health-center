<?php

namespace App\Filament\Widgets;

use App\Models\Company;
use App\Models\Center;
use App\Models\Employee;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrganizationStatsWidget extends StatsOverviewWidget
{
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('تعداد شرکت‌ها', Company::count())
                ->description('شرکت‌های ثبت شده')
                ->descriptionIcon('heroicon-o-building-office')
                ->color('success')
                ->chart([7, 5, 8, 3, 6, 4, 9]),

            Stat::make('مراکز بهداشتی', Center::count())
                ->description('مراکز فعال')
                ->descriptionIcon('heroicon-o-map-pin')
                ->color('primary')
                ->chart([4, 6, 3, 8, 5, 7, 4]),

            Stat::make('تعداد کارکنان', Employee::count())
                ->description('کارکنان ثبت شده')
                ->descriptionIcon('heroicon-o-users')
                ->color('info')
                ->chart([6, 4, 7, 5, 8, 3, 6]),

            Stat::make('کاربران سیستم', User::count())
                ->description('کاربران فعال')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('warning')
                ->chart([3, 5, 2, 7, 4, 6, 5]),
        ];
    }
}
