<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VehicleRequestResource\Pages;
use App\Models\VehicleRequest;
use App\Models\Center;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VehicleRequestResource extends Resource
{
    protected static ?string $model = VehicleRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationGroup = 'امور عمومی';

    protected static ?string $navigationLabel = 'درخواست نقلیه';

    protected static ?string $modelLabel = 'درخواست نقلیه';

    protected static ?string $pluralModelLabel = 'درخواست‌های نقلیه';

    protected static ?string $slug = 'vehicle-requests';

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
                        Forms\Components\Textarea::make('trip_purpose')
                            ->label('هدف سفر')
                            ->rows(2)
                            ->required(),
                    ])->columns(1),

                Forms\Components\Section::make('اطلاعات سفر')
                    ->schema([
                        Forms\Components\TextInput::make('origin')
                            ->label('مبدأ')
                            ->required()
                            ->maxLength(200),
                        Forms\Components\TextInput::make('destination')
                            ->label('مقصد')
                            ->required()
                            ->maxLength(200),
                        Forms\Components\DateTimePicker::make('departure_datetime')
                            ->label('زمان حرکت')
                            ->required(),
                        Forms\Components\DateTimePicker::make('expected_return')
                            ->label('زمان بازگشت'),
                        Forms\Components\TextInput::make('passenger_count')
                            ->label('تعداد مسافرین')
                            ->numeric()
                            ->default(1),
                        Forms\Components\Textarea::make('passenger_list')
                            ->label('لیست مسافرین')
                            ->rows(2),
                    ])->columns(3),

                Forms\Components\Section::make('وضعیت')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('وضعیت')
                            ->options([
                                'ارسال_شده' => 'ارسال شده',
                                'تأیید_شده' => 'تأیید شده',
                                'در_حال_سفر' => 'در حال سفر',
                                'انجام_شده' => 'انجام شده',
                                'رد_شده' => 'رد شده',
                                'لغو_شده' => 'لغو شده',
                            ])
                            ->default('ارسال_شده')
                            ->required(),
                        Forms\Components\Textarea::make('notes')
                            ->label('یادداشت‌ها')
                            ->rows(2),
                    ])->columns(1),
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
                Tables\Columns\TextColumn::make('destination')
                    ->label('مقصد')
                    ->searchable(),
                Tables\Columns\TextColumn::make('departure_datetime')
                    ->label('زمان حرکت')
                    ->dateTime('Y/m/d H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('passenger_count')
                    ->label('مسافر')
                    ->numeric(),
                Tables\Columns\TextColumn::make('status')
                    ->label('وضعیت')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'ارسال_شده' => 'gray',
                        'تأیید_شده' => 'info',
                        'در_حال_سفر' => 'warning',
                        'انجام_شده' => 'success',
                        'رد_شده' => 'danger',
                        'لغو_شده' => 'danger',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('وضعیت')
                    ->options([
                        'ارسال_شده' => 'ارسال شده',
                        'تأیید_شده' => 'تأیید شده',
                        'در_حال_سفر' => 'در حال سفر',
                        'انجام_شده' => 'انجام شده',
                        'رد_شده' => 'رد شده',
                        'لغو_شده' => 'لغو شده',
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
            'index' => Pages\ListVehicleRequests::route('/'),
            'create' => Pages\CreateVehicleRequest::route('/create'),
            'edit' => Pages\EditVehicleRequest::route('/{record}/edit'),
        ];
    }
}
