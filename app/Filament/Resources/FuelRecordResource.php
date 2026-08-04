<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\FuelRecordResource\Pages;
use App\Models\FuelRecord;
use App\Models\Vehicle;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class FuelRecordResource extends Resource
{
    protected static ?string $model = FuelRecord::class;

    protected static ?string $modelLabel = 'سوخت';

    protected static ?string $pluralModelLabel = 'سوابق سوخت';

    protected static ?string $navigationLabel = 'سوابق سوخت';

    protected static string|\UnitEnum|null $navigationGroup = 'پشتیبانی و ناوگان';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Fire;

    protected static ?int $navigationSort = 370;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('ارتباطات')
                ->schema([
                    Forms\Components\Select::make('vehicle_id')
                        ->label('خودرو')
                        ->relationship(name: 'vehicle', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\Vehicle $record) => (string) (($record->plate_number ?? null) ?: ($record->name ?? null) ?: ($record->model ?? null) ?: ('#' . $record->getKey())))
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
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('تاریخ‌ها')
                ->schema([
                    Forms\Components\DatePicker::make('date')
                        ->label('تاریخ')
                        ->native(false),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('وضعیت و نوع')
                ->schema([
                    Forms\Components\Select::make('fuel_type')
                        ->label('نوع سوخت')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('مالی و مقادیر')
                ->schema([
                    Forms\Components\TextInput::make('quantity')
                        ->label('تعداد')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('cost')
                        ->label('هزینه')
                        ->numeric()
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('اطلاعات اصلی')
                ->schema([
                    Forms\Components\TextInput::make('fuel_card_number')
                        ->label('fuel card number')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('mileage')
                        ->label('mileage')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('station')
                        ->label('station')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('receipt_number')
                        ->label('receipt number')
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('توضیحات')
                ->schema([
                    Forms\Components\Textarea::make('notes')
                        ->label('یادداشت')
                        ->rows(3)
                        ->columnSpanFull(),
                ])
                ->columns(2)
                ->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->label('تاریخ')
                    ->searchable()
                    ->sortable()
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('vehicle.plate_number')
                    ->label('خودرو')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('fuel_type')
                    ->label('نوع سوخت')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('تعداد')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('cost')
                    ->label('هزینه')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('fuel_card_number')
                    ->label('fuel card number')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('mileage')
                    ->label('mileage')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('station')
                    ->label('station')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('receipt_number')
                    ->label('receipt number')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('ایجاد')
                    ->dateTime()
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
            'index' => Pages\ListFuelRecords::route('/'),
            'create' => Pages\CreateFuelRecord::route('/create'),
            'edit' => Pages\EditFuelRecord::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
