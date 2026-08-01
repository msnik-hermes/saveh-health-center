<?php

namespace App\Filament\Widgets;

use Illuminate\Support\Facades\DB;
use Filament\Widgets\ChartWidget;

class ProvinceDistributionWidget extends ChartWidget
{
    protected static ?string $heading = 'توزیع جغرافیایی مراکز';
    protected static ?string $description = 'مراکز بر اساس استان';
    protected ?string $maxHeight = '300px';
use Illuminate\Support\Facades\DB;

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $data = DB::table('centers')
            ->select('province', DB::raw('count(*) as total'))
            ->groupBy('province')
            ->orderByDesc('total')
            ->pluck('total', 'province')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'تعداد مراکز',
                    'data' => array_values($data),
                    'backgroundColor' => '#10b981',
                ],
            ],
            'labels' => array_keys($data),
        ];
    }
}
