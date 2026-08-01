<?php

namespace App\Filament\Resources;

use App\Models\DiseaseSurveillance;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;

class DiseaseSurveillanceResource extends Resource
{
    protected static ?string $model = DiseaseSurveillance::class;
    protected static ?string $modelLabel = 'نظارت بیماری';
    protected static ?string $pluralModelLabel = 'نظارت بیماری‌ها';
    protected static ?string $navigationLabel = 'نظارت بیماری‌ها';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\TextInput::make('disease_name')
                ->label('نام بیماری')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('code')
                ->label('کد بیماری')
                ->required()
                ->maxLength(50),
            Forms\Components\DatePicker::make('start_date')
                ->label('تاریخ شروع')
                ->required(),
            Forms\Components\DatePicker::make('end_date')
                ->label('تاریخ پایان')
                ->nullable(),
            Forms\Components\Select::make('severity')
                ->label('شدت')
                ->options([
                    'low' => 'کم',
                    'medium' => 'متوسط',
                    'high' => 'بالا',
                    'critical' => 'بحرانی',
                ])
                ->required()
                ->default('low'),
            Forms\Components\TextInput::make('location')
                ->label('مکان')
                ->maxLength(200),
            Forms\Components\Textarea::make('description')
                ->label('توضیحات')
                ->rows(3)
                ->maxLength(1000),
            Forms\Components\Toggle::make('is_active')
                ->label('فعال')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('disease_name')
                    ->label('نام بیماری')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('code')
                    ->label('کد'),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('تاریخ شروع')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('تاریخ پایان')
                    ->date(),
                Tables\Columns\TextColumn::make('severity')
                    ->label('شدت')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'low' => 'success',
                        'medium' => 'info',
                        'high' => 'warning',
                        'critical' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'low' => 'کم',
                        'medium' => 'متوسط',
                        'high' => 'بالا',
                        'critical' => 'بحرانی',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('location')
                    ->label('مکان'),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('فعال'),
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
            'index' => Pages\ListDiseaseSurveillances::route('/'),
            'create' => Pages\CreateDiseaseSurveillance::route('/create'),
            'edit' => Pages\EditDiseaseSurveillance::route('/{record}/edit'),
        ];
    }
}
