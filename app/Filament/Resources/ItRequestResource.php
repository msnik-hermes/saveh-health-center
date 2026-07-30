<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItRequestResource\Pages;
use App\Models\ItRequest;
use App\Models\Center;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ItRequestResource extends Resource
{
    protected static ?string $model = ItRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';

    protected static ?string $navigationGroup = 'آی‌تی';

    protected static ?string $navigationLabel = 'درخواست آی‌تی';

    protected static ?string $modelLabel = 'درخواست آی‌تی';

    protected static ?string $pluralModelLabel = 'درخواست‌های آی‌تی';

    protected static ?string $slug = 'it-requests';

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
                        Forms\Components\Select::make('service_type')
                            ->label('نوع خدمت')
                            ->options([
                                'تعمیر_کامپیوتر' => 'تعمیر کامپیوتر',
                                'تعمیر_پرینتر' => 'تعمیر پرینتر',
                                'شبکه' => 'شبکه',
                                'نرم‌افزار' => 'نرم‌افزار',
                                'امنیت' => 'امنیت',
                                'اینترنت' => 'اینترنت',
                                'تلفن' => 'تلفن',
                                'سایر' => 'سایر',
                            ])
                            ->required(),
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
                        Forms\Components\Textarea::make('problem_description')
                            ->label('توضیح مشکل')
                            ->rows(3)
                            ->required(),
                        Forms\Components\Textarea::make('error_messages')
                            ->label('پیام‌های خطا')
                            ->rows(2),
                        Forms\Components\TextInput::make('available_time')
                            ->label('زمان در دسترس')
                            ->maxLength(100),
                    ])->columns(1),

                Forms\Components\Section::make('پیگیری')
                    ->schema([
                        Forms\Components\Select::make('assigned_to')
                            ->label('مسئول بررسی')
                            ->options(fn () => Employee::pluck('last_name', 'id'))
                            ->searchable()
                            ->nullable(),
                        Forms\Components\Select::make('status')
                            ->label('وضعیت')
                            ->options([
                                'ارسال_شده' => 'ارسال شده',
                                'تخصیص_یافته' => 'تخصیص یافته',
                                'در_حال_بررسی' => 'در حال بررسی',
                                'حل_شده' => 'حل شده',
                                'رد_شده' => 'رد شده',
                            ])
                            ->default('ارسال_شده')
                            ->required(),
                        Forms\Components\Textarea::make('resolution_notes')
                            ->label('توضیح حل')
                            ->rows(2),
                        Forms\Components\DatePicker::make('completion_date')
                            ->label('تاریخ انجام'),
                        Forms\Components\Textarea::make('notes')
                            ->label('یادداشت‌ها')
                            ->rows(2),
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
                Tables\Columns\TextColumn::make('service_type')
                    ->label('نوع خدمت')
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
                        'در_حال_بررسی' => 'warning',
                        'حل_شده' => 'success',
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
                        'در_حال_بررسی' => 'در حال بررسی',
                        'حل_شده' => 'حل شده',
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
            'index' => Pages\ListItRequests::route('/'),
            'create' => Pages\CreateItRequest::route('/create'),
            'edit' => Pages\EditItRequest::route('/{record}/edit'),
        ];
    }
}
