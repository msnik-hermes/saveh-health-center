<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InspectionResource\Pages;
use App\Models\Inspection;
use App\Models\Center;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InspectionResource extends Resource
{
    protected static ?string $model = Inspection::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationGroup = 'بازرسی‌ها';

    protected static ?string $navigationLabel = 'بازرسی‌های عمومی';

    protected static ?string $modelLabel = 'بازرسی';

    protected static ?string $pluralModelLabel = 'بازرسی‌ها';

    protected static ?string $slug = 'inspections';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('اطلاعات بازرسی')
                    ->schema([
                        Forms\Components\Select::make('center_id')
                            ->label('مرکز')
                            ->options(fn () => Center::pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('inspector_id')
                            ->label('بازرس')
                            ->options(fn () => Employee::pluck('last_name', 'id'))
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('inspection_type')
                            ->label('نوع بازرسی')
                            ->options([
                                'بهداشتی' => 'بهداشتی',
                                'ایمنی' => 'ایمنی',
                                'فنی' => 'فنی',
                                'مالی' => 'مالی',
                                'کیفی' => 'کیفی',
                            ])
                            ->required(),
                        Forms\Components\DatePicker::make('date')
                            ->label('تاریخ بازرسی')
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('یافته‌ها و وضعیت')
                    ->schema([
                        Forms\Components\Textarea::make('findings')
                            ->label('یافته‌ها')
                            ->rows(3)
                            ->required(),
                        Forms\Components\Select::make('compliance_status')
                            ->label('وضعیت انطباق')
                            ->options([
                                'مطلوب' => 'مطلوب',
                                'نیاز_به_اصلاح' => 'نیاز به اصلاح',
                                'بحرانی' => 'بحرانی',
                            ])
                            ->required(),
                        Forms\Components\Textarea::make('notes')
                            ->label('یادداشت‌ها')
                            ->rows(2),
                    ])->columns(1),

                Forms\Components\Section::make('پیگیری')
                    ->schema([
                        Forms\Components\DatePicker::make('next_inspection_date')
                            ->label('بازرسی بعدی'),
                        Forms\Components\Select::make('status')
                            ->label('وضعیت')
                            ->options([
                                'تکمیل_شده' => 'تکمیل شده',
                                'در_حال_بررسی' => 'در حال بررسی',
                            ])
                            ->default('تکمیل_شده')
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('شماره'),
                Tables\Columns\TextColumn::make('center.name')
                    ->label('مرکز')
                    ->sortable(),
                Tables\Columns\TextColumn::make('inspector.last_name')
                    ->label('بازرس'),
                Tables\Columns\TextColumn::make('inspection_type')
                    ->label('نوع')
                    ->badge(),
                Tables\Columns\TextColumn::make('date')
                    ->label('تاریخ')
                    ->date('Y/m/d')
                    ->sortable(),
                Tables\Columns\TextColumn::make('compliance_status')
                    ->label('وضعیت انطباق')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'مطلوب' => 'success',
                        'نیاز_به_اصلاح' => 'warning',
                        'بحرانی' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->label('وضعیت')
                    ->badge(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('inspection_type')
                    ->label('نوع بازرسی')
                    ->options([
                        'بهداشتی' => 'بهداشتی',
                        'ایمنی' => 'ایمنی',
                        'فنی' => 'فنی',
                        'مالی' => 'مالی',
                        'کیفی' => 'کیفی',
                    ]),
                Tables\Filters\SelectFilter::make('compliance_status')
                    ->label('وضعیت انطباق')
                    ->options([
                        'مطلوب' => 'مطلوب',
                        'نیاز_به_اصلاح' => 'نیاز به اصلاح',
                        'بحرانی' => 'بحرانی',
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
            'index' => Pages\ListInspections::route('/'),
            'create' => Pages\CreateInspection::route('/create'),
            'edit' => Pages\EditInspection::route('/{record}/edit'),
        ];
    }
}
