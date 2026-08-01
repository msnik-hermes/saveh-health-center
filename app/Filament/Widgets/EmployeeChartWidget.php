<?php

namespace App\Filament\Widgets;

use App\Models\Employee;
use Filament\Widgets\ChartWidget;

class EmployeeChartWidget extends ChartWidget
{
    protected static ?string $heading = 'توزیع کارکنان بر اساس مرکز';
    protected static ?string $description = 'تعداد کارکنان هر مرکز';
    protected ?string $maxHeight = '300px';
use Illuminate\Support\Facades\DB;

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $data = Employee::select('center_id', \DB::raw('count(*) as total'))
            ->groupBy('center_id')
            ->join('centers', 'employees.center_id', '=', 'centers.id')
            ->pluck('total', 'centers.name')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'تعداد کارکنان',
                    'data' => array_values($data),
                ],
            ],
            'labels' => array_keys($data),
        ];
    }
}
