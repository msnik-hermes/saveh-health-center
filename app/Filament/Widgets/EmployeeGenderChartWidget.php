<?php

namespace App\Filament\Widgets;

use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\ChartWidget;

class EmployeeGenderChartWidget extends ChartWidget
{
    protected static ?string $heading = 'توزیع جنسیت کارکنان';
    protected static ?string $description = 'تعداد مرد و زن';
    protected ?string $maxHeight = '300px';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $data = DB::table('employees')
            ->select('gender', DB::raw('count(*) as total'))
            ->groupBy('gender')
            ->pluck('total', 'gender')
            ->toArray();

        $labels = [];
        $values = [];
        foreach ($data as $gender => $count) {
            $labels[] = match ($gender) {
                'mard' => 'مرد',
                'zan' => 'زن',
                default => $gender,
            };
            $values[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'تعداد',
                    'data' => $values,
                    'backgroundColor' => ['#3b82f6', '#ec4899'],
                ],
            ],
            'labels' => $labels,
        ];
    }
}
