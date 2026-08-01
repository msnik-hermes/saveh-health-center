<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Models\Employee;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;
    protected static ?string $modelLabel = 'کارمند';
    protected static ?string $pluralModelLabel = 'کارکنان';
    protected static ?string $navigationLabel = 'کارکنان';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\TextInput::make('personnel_code')
                ->label('کد پرسنلی')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(20),
            Forms\Components\TextInput::make('first_name')
                ->label('نام')
                ->required()
                ->maxLength(50),
            Forms\Components\TextInput::make('last_name')
                ->label('نام خانوادگی')
                ->required()
                ->maxLength(50),
            Forms\Components\TextInput::make('national_code')
                ->label('کد ملی')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(10),
            Forms\Components\DatePicker::make('birth_date')
                ->label('تاریخ تولد')
                ->required(),
            Forms\Components\Select::make('gender')
                ->label('جنسیت')
                ->options([
                    'mard' => 'مرد',
                    'zan' => 'زن',
                ])
                ->required(),
            Forms\Components\TextInput::make('job_title')
                ->label('عنوان شغلی')
                ->required()
                ->maxLength(200),
            Forms\Components\TextInput::make('position')
                ->label('سمت')
                ->required()
                ->maxLength(100),
            Forms\Components\TextInput::make('department')
                ->label('واحد')
                ->required()
                ->maxLength(100),
            Forms\Components\Select::make('center_id')
                ->label('مرکز')
                ->relationship('center', 'name')
                ->required()
                ->searchable(),
            Forms\Components\Select::make('status')
                ->label('وضعیت')
                ->options([
                    'faal' => 'فعال',
                    'masaf' => 'منتقل',
                    'bazneshaste' => 'بازنشسته',
                    'morakhas' => 'مرخصی',
                ])
                ->default('faal')
                ->required(),
            Forms\Components\TextInput::make('mobile')
                ->label('موبایل')
                ->required()
                ->maxLength(15),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('personnel_code')
                    ->label('کد پرسنلی')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('first_name')
                    ->label('نام')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->label('نام خانوادگی')
                    ->searchable(),
                Tables\Columns\TextColumn::make('national_code')
                    ->label('کد ملی')
                    ->searchable(),
                Tables\Columns\TextColumn::make('job_title')
                    ->label('عنوان شغلی'),
                Tables\Columns\TextColumn::make('department')
                    ->label('واحد'),
                Tables\Columns\TextColumn::make('center.name')
                    ->label('مرکز'),
                Tables\Columns\TextColumn::make('status')
                    ->label('وضعیت')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'faal' => 'success',
                        'masaf' => 'warning',
                        'bazneshaste' => 'danger',
                        'morakhas' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'faal' => 'فعال',
                        'masaf' => 'منتقل',
                        'bazneshaste' => 'بازنشسته',
                        'morakhas' => 'مرخصی',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('mobile')
                    ->label('موبایل'),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
