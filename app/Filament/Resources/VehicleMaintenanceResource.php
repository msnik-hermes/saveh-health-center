<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\VehicleMaintenanceResource\Pages;
use App\Models\Vehicle;
use App\Models\VehicleMaintenance;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class VehicleMaintenanceResource extends Resource
{
    protected static ?string $model = VehicleMaintenance::class;

    protected static ?string $modelLabel = 'تعمیر خودرو';

    protected static ?string $pluralModelLabel = 'تعمیرات خودرو';

    protected static ?string $navigationLabel = 'تعمیرات خودرو';

    protected static string|\UnitEnum|null $navigationGroup = 'پشتیبانی و ناوگان';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Cog6Tooth;

    protected static ?int $navigationSort = 400;

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
            Section::make('وضعیت و نوع')
                ->columns(1)
                ->schema([
                    Forms\Components\Select::make('service_type')
                        ->label('نوع خدمت')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                ]),
            Section::make('تاریخ‌ها')
                ->columns(2)
                ->schema([
                    Forms\Components\DatePicker::make('next_service_date')
                        ->label('next service date')
                        ->native(false),
                    Forms\Components\DatePicker::make('service_date')
                        ->label('تاریخ خدمت')
                        ->native(false),
                ]),
            Section::make('مالی و مقادیر')
                ->columns(1)
                ->schema([
                    Forms\Components\TextInput::make('cost')
                        ->label('هزینه')
                        ->numeric()
                        ->maxLength(255),
                ]),
            Section::make('توضیحات')
                ->columns(1)
                ->schema([
                    Forms\Components\Textarea::make('description')
                        ->label('توضیحات')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('notes')
                        ->label('یادداشت')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),
            Section::make('سایر اطلاعات')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('invoice')
                        ->label('invoice')
                        ->maxLength(255),
                    Forms\Components\DatePicker::make('mileage_at_service')
                        ->label('mileage at service')
                        ->native(false),
                    Forms\Components\TextInput::make('next_service_mileage')
                        ->label('next service mileage')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('parts_replaced')
                        ->label('parts replaced')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('service_provider')
                        ->label('service provider')
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
                Tables\Columns\TextColumn::make('service_date')
                    ->label('تاریخ خدمت')
                    ->searchable()
                    ->sortable()
                    ->jalaliDate()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('service_type')
                    ->label('نوع خدمت')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('mileage_at_service')
                    ->label('mileage at service')
                    ->jalaliDate()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('توضیحات')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('parts_replaced')
                    ->label('parts replaced')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('service_provider')
                    ->label('service provider')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('cost')
                    ->label('هزینه')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('next_service_mileage')
                    ->label('next service mileage')
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
            'index' => Pages\ListVehicleMaintenances::route('/'),
            'create' => Pages\CreateVehicleMaintenance::route('/create'),
            'edit' => Pages\EditVehicleMaintenance::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
