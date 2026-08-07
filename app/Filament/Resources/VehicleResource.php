<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\VehicleResource\Pages;
use App\Models\Center;
use App\Models\Vehicle;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static ?string $modelLabel = 'خودرو';

    protected static ?string $pluralModelLabel = 'خودروها';

    protected static ?string $navigationLabel = 'خودروها';

    protected static string|\UnitEnum|null $navigationGroup = 'پشتیبانی و ناوگان';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Truck;

    protected static ?int $navigationSort = 340;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

                public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->schema([
            Section::make('اطلاعات اصلی')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('model')
                        ->label('مدل')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('plate_number')
                        ->label('پلاک')
                        ->maxLength(255),
                ]),
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
                        ->nullable(),
                    Forms\Components\TextInput::make('created_by')
                        ->label('ایجادکننده')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('updated_by')
                        ->label('ویرایش‌کننده')
                        ->numeric()
                        ->maxLength(255),
                ]),
            Section::make('وضعیت و نوع')
                ->columns(1)
                ->schema([
                    Forms\Components\Select::make('status')
                        ->label('وضعیت')
                        ->options(['active' => 'فعال', 'inactive' => 'غیرفعال', 'pending' => 'در انتظار', 'approved' => 'تأیید شده', 'rejected' => 'رد شده', 'completed' => 'تکمیل شده', 'cancelled' => 'لغو شده', 'draft' => 'پیش‌نویس', 'open' => 'باز', 'closed' => 'بسته', 'in_progress' => 'در حال انجام', 'suspended' => 'معلق', 'resolved' => 'حل‌شده', 'failed' => 'ناموفق'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
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
                    Forms\Components\TextInput::make('chassis_number')
                        ->label('شماره شاسی')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('color')
                        ->label('رنگ')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('engine_number')
                        ->label('شماره موتور')
                        ->maxLength(255),
                    Forms\Components\Select::make('fuel_type')
                        ->label('نوع سوخت')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\TextInput::make('gps_device')
                        ->label('gps device')
                        ->maxLength(255),
                    Forms\Components\DatePicker::make('insurance_expiry')
                        ->label('insurance expiry')
                        ->native(false),
                    Forms\Components\TextInput::make('insurance_number')
                        ->label('شماره بیمه')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('make')
                        ->label('make')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('photo')
                        ->label('photo')
                        ->maxLength(255),
                    Forms\Components\DatePicker::make('registration_expiry')
                        ->label('registration expiry')
                        ->native(false),
                    Forms\Components\TextInput::make('tank_capacity')
                        ->label('tank capacity')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('total_mileage')
                        ->label('total mileage')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\Select::make('vehicle_type')
                        ->label('vehicle type')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\TextInput::make('year')
                        ->label('سال')
                        ->numeric()
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
                Tables\Columns\TextColumn::make('plate_number')
                    ->label('پلاک')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('make')
                    ->label('make')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('model')
                    ->label('مدل')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('year')
                    ->label('سال')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('color')
                    ->label('رنگ')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('vehicle_type')
                    ->label('vehicle type')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('engine_number')
                    ->label('شماره موتور')
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
            'index' => Pages\ListVehicles::route('/'),
            'create' => Pages\CreateVehicle::route('/create'),
            'edit' => Pages\EditVehicle::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
