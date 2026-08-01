<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InspectionResource\Pages;
use App\Models\Inspection;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;
use Filament\Actions;

class InspectionResource extends Resource
{
    protected static ?string $model = Inspection::class;
    protected static ?string $modelLabel = 'بازرسی';
    protected static ?string $pluralModelLabel = 'بازرسی‌ها';
    protected static ?string $navigationLabel = 'بازرسی‌ها';
    protected static ?string $slug = 'inspections';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('اطلاعات بازرسی')
                ->schema([
                    Forms\Components\Select::make('center_id')
                        ->label('مرکز')
                        ->relationship('center', 'name')
                        ->required()
                        ->searchable(),
                    Forms\Components\Select::make('inspector_id')
                        ->label('بازرس')
                        ->relationship('inspector', 'first_name')
                        ->searchable(),
                    Forms\Components\Select::make('inspection_type')
                        ->label('نوع بازرسی')
                        ->options([
                            'behdashti' => 'بهداشتی',
                            'amniati' => 'امنیتی',
                            'fanghi' => 'فنی',
                            'ghanooni' => 'قانونی',
                        ])
                        ->default('behdashti')
                        ->required(),
                    Forms\Components\DatePicker::make('date')
                        ->label('تاریخ بازرسی')
                        ->required(),
                ])->columns(2),

            Section::make('یافته‌ها و نتایج')
                ->schema([
                    Forms\Components\Textarea::make('findings')
                        ->label('یافته‌ها')
                        ->required()
                        ->rows(4),
                    Forms\Components\Select::make('compliance_status')
                        ->label('وضعیت انطباق')
                        ->options([
                            'motlob' => 'مطلوب',
                            'naghiz' => 'ناقص',
                            'ghair_motlob' => 'غیر مطلوب',
                        ])
                        ->default('motlob'),
                    Forms\Components\Textarea::make('corrective_actions')
                        ->label('اقدامات اصلاحی')
                        ->rows(3),
                    Forms\Components\Textarea::make('notes')
                        ->label('یادداشت‌ها')
                        ->rows(3),
                ])->columns(2),

            Section::make('برنامه‌ریزی')
                ->schema([
                    Forms\Components\DatePicker::make('next_inspection_date')
                        ->label('تاریخ بازدید بعدی'),
                    Forms\Components\Select::make('status')
                        ->label('وضعیت')
                        ->options([
                            'takmil_shodeh' => 'تکمیل شده',
                            'dar_jaryan' => 'در جریان',
                            'laghv_shodeh' => 'لغو شده',
                        ])
                        ->default('takmil_shodeh')
                        ->required(),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('center.name')
                    ->label('مرکز')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('inspection_type')
                    ->label('نوع')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'behdashti' => 'success',
                        'amniati' => 'danger',
                        'fanghi' => 'warning',
                        'ghanooni' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'behdashti' => 'بهداشتی',
                        'amniati' => 'امنیتی',
                        'fanghi' => 'فنی',
                        'ghanooni' => 'قانونی',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('date')
                    ->label('تاریخ')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('compliance_status')
                    ->label('انطباق')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'motlob' => 'success',
                        'naghiz' => 'warning',
                        'ghair_motlob' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'motlob' => 'مطلوب',
                        'naghiz' => 'ناقص',
                        'ghair_motlob' => 'غیر مطلوب',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->label('وضعیت')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'takmil_shodeh' => 'success',
                        'dar_jaryan' => 'warning',
                        'laghv_shodeh' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'takmil_shodeh' => 'تکمیل شده',
                        'dar_jaryan' => 'در جریان',
                        'laghv_shodeh' => 'لغو شده',
                        default => $state,
                    }),
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
