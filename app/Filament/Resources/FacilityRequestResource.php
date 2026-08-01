<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FacilityRequestResource\Pages;
use App\Models\FacilityRequest;
use App\Models\Center;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FacilityRequestResource extends Resource
{
    protected static ?string $model = FacilityRequest::class;


    protected static string | NITENUM | NULL $NAVIGATIONGROUP = 'امور عمومی';

    protected static ?string $navigationLabel = 'درخواست تاسیسات';

    protected static ?string $modelLabel = 'درخواست تاسیسات';

    protected static ?string $pluralModelLabel = 'درخواست‌های تاسیسات';

    protected static ?string $slug = 'facility-requests';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('اطلاعات درخواست')
                    ->schema([
                        Forms\Components\Select::make('center_id')
                            ->label('مرکز')
                            ->options(fn () => Center::pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('requested_by')
                            ->label('درخواست‌دهنده')
                            ->options(fn () => Employee::pluck('last_name', 'id'))
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('facility_type')
                            ->label('نوع تاسیسات')
                            ->options([
                                'لوله_کشی' => 'لوله کشی',
                                'برق' => 'برق',
                                'گاز' => 'گاز',
                                'سرمایش' => 'سرمایش',
                                'گرمایش' => 'گرمایش',
                                'نقاشی' => 'نقاشی',
                                'بنایی' => 'بنایی',
                                'نظافت' => 'نظافت',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('location')
                            ->label('محل')
                            ->required()
                            ->maxLength(200),
                        Forms\Components\Select::make('priority')
                            ->label('اولویت')
                            ->options([
                                'عادی' => 'عادی',
                                'فوری' => 'فوری',
                                'بحرانی' => 'بحرانی',
                            ])
                            ->default('عادی')
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('توضیحات')
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->label('توضیح مشکل')
                            ->rows(3)
                            ->required(),
                        Forms\Components\DateTimePicker::make('preferred_time')
                            ->label('زمان مورد نظر'),
                        Forms\Components\Textarea::make('notes')
                            ->label('یادداشت‌ها')
                            ->rows(2),
                    ])->columns(1),

                Forms\Components\Section::make('پیگیری')
                    ->schema([
                        Forms\Components\Toggle::make('budget_approval')
                            ->label('تأیید بودجه'),
                        Forms\Components\Select::make('assigned_to')
                            ->label('مسئول اجرا')
                            ->options(fn () => Employee::pluck('last_name', 'id'))
                            ->searchable()
                            ->nullable(),
                        Forms\Components\Select::make('status')
                            ->label('وضعیت')
                            ->options([
                                'ارسال_شده' => 'ارسال شده',
                                'تخصیص_یافته' => 'تخصیص یافته',
                                'در_حال_انجام' => 'در حال انجام',
                                'انجام_شده' => 'انجام شده',
                                'رد_شده' => 'رد شده',
                            ])
                            ->default('ارسال_شده')
                            ->required(),
                        Forms\Components\DatePicker::make('completion_date')
                            ->label('تاریخ انجام'),
                        Forms\Components\TextInput::make('cost')
                            ->label('هزینه (ریال)')
                            ->numeric()
                            ->decimalDigits(0),
                    ])->columns(3),
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
                Tables\Columns\TextColumn::make('requestedBy.last_name')
                    ->label('درخواست‌دهنده'),
                Tables\Columns\TextColumn::make('facility_type')
                    ->label('نوع')
                    ->badge(),
                Tables\Columns\TextColumn::make('priority')
                    ->label('اولویت')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'عادی' => 'gray',
                        'فوری' => 'warning',
                        'بحرانی' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->label('وضعیت')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'ارسال_شده' => 'gray',
                        'تخصیص_یافته' => 'info',
                        'در_حال_انجام' => 'warning',
                        'انجام_شده' => 'success',
                        'رد_شده' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاریخ ثبت')
                    ->date('Y/m/d')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('وضعیت')
                    ->options([
                        'ارسال_شده' => 'ارسال شده',
                        'تخصیص_یافته' => 'تخصیص یافته',
                        'در_حال_انجام' => 'در حال انجام',
                        'انجام_شده' => 'انجام شده',
                        'رد_شده' => 'رد شده',
                    ]),
                Tables\Filters\SelectFilter::make('priority')
                    ->label('اولویت')
                    ->options([
                        'عادی' => 'عادی',
                        'فوری' => 'فوری',
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
            'index' => Pages\ListFacilityRequests::route('/'),
            'create' => Pages\CreateFacilityRequest::route('/create'),
            'edit' => Pages\EditFacilityRequest::route('/{record}/edit'),
        ];
    }
}
