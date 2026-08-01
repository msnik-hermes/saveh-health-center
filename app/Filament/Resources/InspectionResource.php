<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InspectionResource\Pages;
use App\Models\Inspection;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;

class InspectionResource extends Resource
{
    protected static ?string $model = Inspection::class;
    protected static ?string $modelLabel = 'بازرسی';
    protected static ?string $pluralModelLabel = 'بازرسی‌ها';
    protected static ?string $navigationLabel = 'بازرسی‌ها';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\Select::make('company_id')
                ->label('شرکت')
                ->relationship('company', 'name')
                ->required()
                ->searchable()
                ->preload(),
            Forms\Components\DatePicker::make('inspection_date')
                ->label('تاریخ بازرسی')
                ->required(),
            Forms\Components\Select::make('inspector_id')
                ->label('بازنگر')
                ->relationship('inspector', 'first_name')
                ->required()
                ->searchable()
                ->preload(),
            Forms\Components\Select::make('status')
                ->label('وضعیت')
                ->options([
                    'pending' => 'در انتظار',
                    'completed' => 'تکمیل شده',
                    'failed' => 'ناموفق',
                ])
                ->required()
                ->default('pending'),
            Forms\Components\Textarea::make('findings')
                ->label('یافته‌ها')
                ->rows(3)
                ->maxLength(1000),
            Forms\Components\Textarea::make('recommendations')
                ->label('توصیه‌ها')
                ->rows(3)
                ->maxLength(1000),
            Forms\Components\DatePicker::make('follow_up_date')
                ->label('تاریخ پیگیری')
                ->nullable(),
            Forms\Components\Select::make('hazard_assessment_id')
                ->label('ارزیابی خطر')
                ->relationship('hazardAssessment', 'id')
                ->nullable()
                ->searchable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('شناسه'),
                Tables\Columns\TextColumn::make('company.name')
                    ->label('شرکت')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('inspection_date')
                    ->label('تاریخ بازرسی')
                    ->sortable(),
                Tables\Columns\TextColumn::make('inspector.first_name')
                    ->label('بازنگر')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('وضعیت')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'completed' => 'success',
                        'failed' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'در انتظار',
                        'completed' => 'تکمیل شده',
                        'failed' => 'ناموفق',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('follow_up_date')
                    ->label('پیگیری')
                    ->date(),
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
            'index' => Pages\ListInspections::route('/'),
            'create' => Pages\CreateInspection::route('/create'),
            'edit' => Pages\EditInspection::route('/{record}/edit'),
        ];
    }
}
