<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\DriverResource\Pages;
use App\Models\Driver;
use App\Models\Employee;
use App\Models\Vehicle;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DriverResource extends Resource
{
    protected static ?string $model = Driver::class;

    protected static ?string $modelLabel = 'راننده';

    protected static ?string $pluralModelLabel = 'رانندگان';

    protected static ?string $navigationLabel = 'رانندگان';

    protected static string|\UnitEnum|null $navigationGroup = 'پشتیبانی و ناوگان';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Identification;

    protected static ?int $navigationSort = 350;

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
                ->columns(1)
                ->schema([
                    Forms\Components\TextInput::make('license_number')
                        ->label('شماره مجوز')
                        ->maxLength(255),
                ]),
            Section::make('ارتباطات')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('assigned_vehicle_id')
                        ->label('assigned vehicle')
                        ->relationship(name: 'assignedVehicle', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\Vehicle $record) => (string) (($record->plate_number ?? null) ?: ($record->name ?? null) ?: ($record->model ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\TextInput::make('created_by')
                        ->label('ایجادکننده')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\Select::make('employee_id')
                        ->label('کارمند')
                        ->relationship(name: 'employee', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\Employee $record) => (string) (($record->first_name ?? null) ?: ($record->last_name ?? null) ?: ($record->personnel_code ?? null) ?: ($record->name ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),
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
            Section::make('تاریخ‌ها')
                ->columns(1)
                ->schema([
                    Forms\Components\DatePicker::make('license_expiry')
                        ->label('انقضای مجوز')
                        ->native(false),
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
                    Forms\Components\TextInput::make('driving_record')
                        ->label('driving record')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('fuel_card_number')
                        ->label('fuel card number')
                        ->maxLength(255),
                    Forms\Components\Select::make('license_type')
                        ->label('license type')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
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
                Tables\Columns\TextColumn::make('employee.first_name')
                    ->label('کارمند')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('license_number')
                    ->label('شماره مجوز')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('license_type')
                    ->label('license type')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('license_expiry')
                    ->label('انقضای مجوز')
                    ->jalaliDate()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('assignedVehicle.plate_number')
                    ->label('assigned vehicle')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('fuel_card_number')
                    ->label('fuel card number')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('driving_record')
                    ->label('driving record')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('notes')
                    ->label('یادداشت')
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
                Tables\Filters\SelectFilter::make('employee_id')
                    ->label('کارمند')
                    ->relationship('employee', 'id')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\Employee $record) => (string) ((($record->first_name ?? null) ?: ($record->last_name ?? null) ?: ($record->personnel_code ?? null) ?: ($record->name ?? null)) ?: ('#' . $record->getKey())))
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('assigned_vehicle_id')
                    ->label('assigned vehicle')
                    ->relationship('assignedVehicle', 'id')
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
            'index' => Pages\ListDrivers::route('/'),
            'create' => Pages\CreateDriver::route('/create'),
            'edit' => Pages\EditDriver::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
