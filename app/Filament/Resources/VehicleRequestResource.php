<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\VehicleRequestResource\Pages;
use App\Models\Center;
use App\Models\Driver;
use App\Models\Employee;
use App\Models\Vehicle;
use App\Models\VehicleRequest;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class VehicleRequestResource extends Resource
{
    protected static ?string $model = VehicleRequest::class;

    protected static ?string $modelLabel = 'درخواست خودرو';

    protected static ?string $pluralModelLabel = 'درخواست‌های خودرو';

    protected static ?string $navigationLabel = 'درخواست‌های خودرو';

    protected static string|\UnitEnum|null $navigationGroup = 'پشتیبانی و ناوگان';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Map;

    protected static ?int $navigationSort = 330;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

                public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->schema([
            Section::make('ارتباطات')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('center_id')
                        ->label('مرکز')
                        ->relationship(name: 'center', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\Center $record) => (string) (($record->name ?? null) ?: ($record->code ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->required(),
                    Forms\Components\TextInput::make('created_by')
                        ->label('ایجادکننده')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\Select::make('driver_id')
                        ->label('راننده')
                        ->relationship(name: 'driver', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\Driver $record) => (string) (($record->name ?? null) ?: ($record->employee_id ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('requested_by')
                        ->label('درخواست‌کننده')
                        ->relationship(name: 'requestedBy', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\Employee $record) => (string) (($record->first_name ?? null) ?: ($record->last_name ?? null) ?: ($record->personnel_code ?? null) ?: ($record->name ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\TextInput::make('updated_by')
                        ->label('ویرایش‌کننده')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\Select::make('vehicle_id')
                        ->label('خودرو')
                        ->relationship(name: 'vehicle', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\Vehicle $record) => (string) (($record->plate_number ?? null) ?: ($record->name ?? null) ?: ($record->model ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),
                ]),
            Section::make('مکان و تماس')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('origin')
                        ->label('مبدأ')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('destination')
                        ->label('مقصد')
                        ->maxLength(255),
                ]),
            Section::make('وضعیت و نوع')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('status')
                        ->label('وضعیت')
                        ->options(['active' => 'فعال', 'inactive' => 'غیرفعال', 'pending' => 'در انتظار', 'approved' => 'تأیید شده', 'rejected' => 'رد شده', 'completed' => 'تکمیل شده', 'cancelled' => 'لغو شده', 'draft' => 'پیش‌نویس', 'open' => 'باز', 'closed' => 'بسته', 'in_progress' => 'در حال انجام', 'suspended' => 'معلق', 'resolved' => 'حل‌شده', 'failed' => 'ناموفق'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\TextInput::make('trip_purpose')
                        ->label('trip purpose')
                        ->maxLength(255),
                ]),
            Section::make('تاریخ‌ها')
                ->columns(2)
                ->schema([
                    Forms\Components\DateTimePicker::make('departure_datetime')
                        ->label('departure datetime')
                        ->native(false)
                        ->seconds(false),
                    Forms\Components\DateTimePicker::make('expected_return')
                        ->label('expected return')
                        ->native(false)
                        ->seconds(false),
                ]),
            Section::make('توضیحات')
                ->columns(1)
                ->schema([
                    Forms\Components\Textarea::make('notes')
                        ->label('یادداشت')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),
            Section::make('سایر اطلاعات')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('passenger_count')
                        ->label('passenger count')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('passenger_list')
                        ->label('passenger list')
                        ->maxLength(255),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('status')
                    ->label('وضعیت')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('center.name')
                    ->label('مرکز')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('requestedBy.first_name')
                    ->label('درخواست‌کننده')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('vehicle.plate_number')
                    ->label('خودرو')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('driver.name')
                    ->label('راننده')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('trip_purpose')
                    ->label('trip purpose')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('origin')
                    ->label('مبدأ')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('destination')
                    ->label('مقصد')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('departure_datetime')
                    ->label('departure datetime')
                    ->jalaliDate()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('ایجاد')
                    ->jalaliDateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('وضعیت')
                    ->options(['active' => 'فعال', 'inactive' => 'غیرفعال', 'pending' => 'در انتظار', 'approved' => 'تأیید شده', 'rejected' => 'رد شده', 'completed' => 'تکمیل شده', 'cancelled' => 'لغو شده', 'draft' => 'پیش‌نویس', 'open' => 'باز', 'closed' => 'بسته', 'in_progress' => 'در حال انجام', 'suspended' => 'معلق', 'resolved' => 'حل‌شده', 'failed' => 'ناموفق']),
                Tables\Filters\SelectFilter::make('center_id')
                    ->label('مرکز')
                    ->relationship('center', 'id')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\Center $record) => (string) ((($record->name ?? null) ?: ($record->code ?? null)) ?: ('#' . $record->getKey())))
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('requested_by')
                    ->label('درخواست‌کننده')
                    ->relationship('requestedBy', 'id')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\Employee $record) => (string) ((($record->first_name ?? null) ?: ($record->last_name ?? null) ?: ($record->personnel_code ?? null) ?: ($record->name ?? null)) ?: ('#' . $record->getKey())))
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('vehicle_id')
                    ->label('خودرو')
                    ->relationship('vehicle', 'id')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\Vehicle $record) => (string) ((($record->plate_number ?? null) ?: ($record->name ?? null) ?: ($record->model ?? null)) ?: ('#' . $record->getKey())))
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('driver_id')
                    ->label('راننده')
                    ->relationship('driver', 'id')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\Driver $record) => (string) ((($record->name ?? null) ?: ($record->employee_id ?? null)) ?: ('#' . $record->getKey())))
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVehicleRequests::route('/'),
            'create' => Pages\CreateVehicleRequest::route('/create'),
            'edit' => Pages\EditVehicleRequest::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
