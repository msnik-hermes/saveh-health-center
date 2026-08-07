<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\VehicleTripResource\Pages;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\VehicleRequest;
use App\Models\VehicleTrip;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class VehicleTripResource extends Resource
{
    protected static ?string $model = VehicleTrip::class;

    protected static ?string $modelLabel = 'سفر خودرو';

    protected static ?string $pluralModelLabel = 'سفرهای خودرو';

    protected static ?string $navigationLabel = 'سفرهای خودرو';

    protected static string|\UnitEnum|null $navigationGroup = 'پشتیبانی و ناوگان';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::MapPin;

    protected static ?int $navigationSort = 360;

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
                    Forms\Components\Select::make('vehicle_request_id')
                        ->label('vehicle request')
                        ->relationship(name: 'vehicleRequest', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\VehicleRequest $record) => (string) (($record->name ?? null) ?: ($record->title ?? null) ?: ($record->code ?? null) ?: ($record->full_name ?? null) ?: ($record->id ?? null) ?: ('#' . $record->getKey())))
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
                ->columns(1)
                ->schema([
                    Forms\Components\TextInput::make('trip_purpose')
                        ->label('trip purpose')
                        ->maxLength(255),
                ]),
            Section::make('تاریخ‌ها')
                ->columns(1)
                ->schema([
                    Forms\Components\DatePicker::make('trip_date')
                        ->label('تاریخ سفر')
                        ->native(false),
                ]),
            Section::make('مالی و مقادیر')
                ->columns(1)
                ->schema([
                    Forms\Components\TextInput::make('fuel_cost')
                        ->label('هزینه سوخت')
                        ->numeric()
                        ->maxLength(255),
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
                    Forms\Components\DateTimePicker::make('departure_time')
                        ->label('departure time')
                        ->native(false)
                        ->seconds(false),
                    Forms\Components\TextInput::make('end_mileage')
                        ->label('end mileage')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('fuel_filled')
                        ->label('fuel filled')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('passenger_list')
                        ->label('passenger list')
                        ->maxLength(255),
                    Forms\Components\DateTimePicker::make('return_time')
                        ->label('return time')
                        ->native(false)
                        ->seconds(false),
                    Forms\Components\TextInput::make('route')
                        ->label('route')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('start_mileage')
                        ->label('start mileage')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('total_distance')
                        ->label('total distance')
                        ->numeric()
                        ->maxLength(255),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
                Tables\Columns\TextColumn::make('vehicleRequest.name')
                    ->label('vehicle request')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('trip_date')
                    ->label('تاریخ سفر')
                    ->jalaliDate()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('departure_time')
                    ->label('departure time')
                    ->jalaliDate()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('return_time')
                    ->label('return time')
                    ->jalaliDate()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('origin')
                    ->label('مبدأ')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('destination')
                    ->label('مقصد')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('route')
                    ->label('route')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('ایجاد')
                    ->jalaliDateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
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
                Tables\Filters\SelectFilter::make('vehicle_request_id')
                    ->label('vehicle request')
                    ->relationship('vehicleRequest', 'id')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\VehicleRequest $record) => (string) ((($record->name ?? null) ?: ($record->title ?? null) ?: ($record->code ?? null) ?: ($record->full_name ?? null) ?: ($record->id ?? null)) ?: ('#' . $record->getKey())))
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
            'index' => Pages\ListVehicleTrips::route('/'),
            'create' => Pages\CreateVehicleTrip::route('/create'),
            'edit' => Pages\EditVehicleTrip::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
