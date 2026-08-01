<?php

namespace App\Filament\Widgets;

use Illuminate\Support\Facades\DB;
use Filament\Widgets\ChartWidget;

class CompanyStatusWidget extends ChartWidget
{
    protected static ?string $heading = 'وضعیت شرکت‌ها';
    protected static ?string $description = 'توزیع وضعیت شرکت‌ها';
    protected ?string $maxHeight = '300px';
use Illuminate\Support\Facades\DB;

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $data = DB::table('companies')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return [
            'datasets' => [
                [
                    'data' => array_values($data),
                    'backgroundColor' => ['#10b981', '#ef4444', '#f59e0b', '#6b7280'],
                ],
            ],
            'labels' => array_keys($data),
        ];
    }
}
