<?php

namespace App\Filament\Widgets;

use App\Models\Company;
use App\Models\Center;
use App\Models\Employee;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class RecentActivityWidget extends TableWidget
use Illuminate\Support\Facades\DB;
{
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'آخرین فعالیت‌ها';
    protected static ?string $description = 'آخرین شرکت‌ها، مراکز و کارکنان';

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $companies = Company::query()->select(
            \DB::raw("'شرکت' as type"),
            'name',
            \DB::raw("COALESCE(city, '-') as detail"),
            'created_at'
        );

        $centers = Center::query()->select(
            \DB::raw("'مرکز' as type"),
            'name',
            \DB::raw("COALESCE(code, '-') as detail"),
            'created_at'
        );

        $employees = Employee::query()->select(
            \DB::raw("'کارمند' as type"),
            \DB::raw("CONCAT(COALESCE(first_name, ''), ' ', COALESCE(last_name, '')) as name"),
            \DB::raw("COALESCE(personnel_code, '-') as detail"),
            'created_at'
        );

        return $employees->unionAll($companies)->unionAll($centers)
            ->orderBy('created_at', 'desc')
            ->limit(15);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('نوع')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'شرکت' => 'success',
                        'مرکز' => 'primary',
                        'کارمند' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('name')
                    ->label('نام'),
                Tables\Columns\TextColumn::make('detail')
                    ->label('جزئیات'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('زمان')
                    ->dateTime()
                    ->sortable(),
            ])
            ->paginated([10]);
    }
}
