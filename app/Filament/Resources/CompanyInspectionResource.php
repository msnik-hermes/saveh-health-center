<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyInspectionResource\Pages;
use App\Models\CompanyInspection;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CompanyInspectionResource extends Resource
{
    protected static ?string $model = CompanyInspection::class;


    protected static string | NITENUM | NULL $NAVIGATIONGROUP = 'بهداشت حرفه‌ای';

    protected static ?string $navigationLabel = 'بازدید شرکت‌ها';

    protected static ?string $modelLabel = 'بازدید شرکت';

    protected static ?string $pluralModelLabel = 'بازدیدهای شرکت‌ها';

    protected static ?string $slug = 'company-inspections';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('اطلاعات شرکت')
                    ->schema([
                        Forms\Components\TextInput::make('company_name')
                            ->label('نام شرکت')
                            ->required()
                            ->maxLength(200),
                        Forms\Components\Select::make('inspector_id')
                            ->label('بازرس')
                            ->options(fn () => Employee::pluck('last_name', 'id'))
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('inspection_type')
                            ->label('نوع بازدید')
                            ->options([
                                'عادی' => 'عادی',
                                'پیگیری' => 'پیگیری',
                                'شکایت' => 'شکایت',
                                'بررسی' => 'بررسی',
                            ])
                            ->required(),
                        Forms\Components\DatePicker::make('inspection_date')
                            ->label('تاریخ بازدید')
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('یافته‌ها')
                    ->schema([
                        Forms\Components\Textarea::make('findings')
                            ->label('یافته‌ها')
                            ->rows(3)
                            ->required(),
                        Forms\Components\TextInput::make('workers_inspected')
                            ->label('تعداد کارگران')
                            ->numeric(),
                        Forms\Components\TextInput::make('violations_found')
                            ->label('تعداد تخلفات')
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('compliance_score')
                            ->label('نمره انطباق')
                            ->numeric()
                            ->decimalDigits(2),
                    ])->columns(2),

                Forms\Components\Section::make('اقدامات اصلاحی')
                    ->schema([
                        Forms\Components\Textarea::make('corrective_actions')
                            ->label('اقدامات اصلاحی')
                            ->rows(3),
                        Forms\Components\DatePicker::make('next_inspection_date')
                            ->label('بازدید بعدی'),
                        Forms\Components\Select::make('status')
                            ->label('وضعیت')
                            ->options([
                                'تکمیل_شده' => 'تکمیل شده',
                                'در_حال_بررسی' => 'در حال بررسی',
                                'پیگیری' => 'پیگیری',
                            ])
                            ->default('تکمیل_شده')
                            ->required(),
                        Forms\Components\Textarea::make('notes')
                            ->label('یادداشت‌ها')
                            ->rows(2),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('شماره'),
                Tables\Columns\TextColumn::make('company_name')
                    ->label('نام شرکت')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('inspector.last_name')
                    ->label('بازرس'),
                Tables\Columns\TextColumn::make('inspection_type')
                    ->label('نوع')
                    ->badge(),
                Tables\Columns\TextColumn::make('inspection_date')
                    ->label('تاریخ بازدید')
                    ->date('Y/m/d')
                    ->sortable(),
                Tables\Columns\TextColumn::make('workers_inspected')
                    ->label('کارگران'),
                Tables\Columns\TextColumn::make('violations_found')
                    ->label('تخلفات')
                    ->numeric(),
                Tables\Columns\TextColumn::make('compliance_score')
                    ->label('نمره')
                    ->numeric(),
                Tables\Columns\TextColumn::make('status')
                    ->label('وضعیت')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'تکمیل_شده' => 'success',
                        'در_حال_بررسی' => 'warning',
                        'پیگیری' => 'info',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('وضعیت')
                    ->options([
                        'تکمیل_شده' => 'تکمیل شده',
                        'در_حال_بررسی' => 'در حال بررسی',
                        'پیگیری' => 'پیگیری',
                    ]),
                Tables\Filters\SelectFilter::make('inspection_type')
                    ->label('نوع بازدید')
                    ->options([
                        'عادی' => 'عادی',
                        'پیگیری' => 'پیگیری',
                        'شکایت' => 'شکایت',
                        'بررسی' => 'بررسی',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
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
