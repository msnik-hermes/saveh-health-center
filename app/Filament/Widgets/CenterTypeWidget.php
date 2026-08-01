<?php

namespace App\Filament\Widgets;

use Illuminate\Support\Facades\DB;
use Filament\Widgets\ChartWidget;

class CenterTypeWidget extends ChartWidget
{
    protected static ?string $heading = 'انواع مراکز';
    protected static ?string $description = 'توزیع مراکز بر اساس نوع';
    protected ?string $maxHeight = '300px';
use Illuminate\Support\Facades\DB;

    protected function getType(): string
    {
        return 'pie';
    }

    protected function getData(): array
    {
        $data = DB::table('centers')
            ->select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->pluck('total', 'type')
            ->toArray();

        $colors = ['#10b981', '#3b82f6', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899'];

        return [
            'datasets' => [
                [
                    'data' => array_values($data),
                    'backgroundColor' => array_slice($colors, 0, count($data)),
                ],
            ],
            'labels' => array_keys($data),
        ];
    }
}
