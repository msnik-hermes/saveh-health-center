<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyInspectionResource\Pages;
use App\Models\CompanyInspection;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;
use Filament\Actions;

class CompanyInspectionResource extends Resource
{
    protected static ?string $model = CompanyInspection::class;
    protected static ?string $modelLabel = 'بازدید شرکت';
    protected static ?string $pluralModelLabel = 'بازدیدهای شرکت';
    protected static ?string $navigationLabel = 'بازدید شرکت‌ها';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('اطلاعات بازدید')
                ->schema([
                    Forms\Components\TextInput::make('company_name')
                        ->label('نام شرکت')
                        ->required()
                        ->maxLength(200),
                    Forms\Components\Select::make('inspection_type')
                        ->label('نوع بازدید')
                        ->options([
                            'adii' => 'ادواری',
                            'sanaati' => 'صنعتی',
                            'pezeshki' => 'پزشکی',
                            'ghanooni' => 'قانونی',
                        ])
                        ->required(),
                    Forms\Components\DatePicker::make('inspection_date')
                        ->label('تاریخ بازدید')
                        ->required(),
                    Forms\Components\TextInput::make('workers_inspected')
                        ->label('تعداد کارگران بازدید شده')
                        ->numeric(),
                ])->columns(2),

            Section::make('یافته‌ها')
                ->schema([
                    Forms\Components\Textarea::make('findings')
                        ->label('یافته‌ها')
                        ->required()
                        ->rows(4),
                    Forms\Components\TextInput::make('violations_found')
                        ->label('تعداد تخلفات')
                        ->numeric(),
                    Forms\Components\TextInput::make('compliance_score')
                        ->label('امتیاز انطباق')
                        ->numeric(),
                    Forms\Components\Textarea::make('violations')
                        ->label('تخلفات')
                        ->rows(3),
                    Forms\Components\Textarea::make('corrective_actions')
                        ->label('اقدامات اصلاحی')
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
                Tables\Columns\TextColumn::make('company_name')
                    ->label('شرکت')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('inspection_type')
                    ->label('نوع')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'adii' => 'primary',
                        'sanaati' => 'warning',
                        'pezeshki' => 'success',
                        'ghanooni' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'adii' => 'ادواری',
                        'sanaati' => 'صنعتی',
                        'pezeshki' => 'پزشکی',
                        'ghanooni' => 'قانونی',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('inspection_date')
                    ->label('تاریخ')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('violations_found')
                    ->label('تخلفات')
                    ->sortable(),
                Tables\Columns\TextColumn::make('compliance_score')
                    ->label('امتیاز')
                    ->sortable(),
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
            'index' => Pages\ListCompanyInspections::route('/'),
            'create' => Pages\CreateCompanyInspection::route('/create'),
            'edit' => Pages\EditCompanyInspection::route('/{record}/edit'),
        ];
    }
}
