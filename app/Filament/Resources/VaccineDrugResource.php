<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\VaccineDrugResource\Pages;
use App\Models\VaccineDrug;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class VaccineDrugResource extends Resource
{
    protected static ?string $model = VaccineDrug::class;

    protected static ?string $modelLabel = 'واکسن/دارو';

    protected static ?string $pluralModelLabel = 'واکسن‌ها و داروها';

    protected static ?string $navigationLabel = 'واکسن و دارو';

    protected static string|\UnitEnum|null $navigationGroup = 'مالی و انبار';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Beaker;

    protected static ?int $navigationSort = 740;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('اطلاعات اصلی')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('نام')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('generic_name')
                        ->label('generic name')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('code')
                        ->label('کد')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('manufacturer')
                        ->label('تولیدکننده')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('batch_number')
                        ->label('شماره بچ')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('form')
                        ->label('form')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('strength')
                        ->label('strength')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('storage_temperature')
                        ->label('storage temperature')
                        ->numeric()
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('وضعیت و نوع')
                ->schema([
                    Forms\Components\Select::make('type')
                        ->label('نوع')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('category')
                        ->label('دسته')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Toggle::make('is_controlled')
                        ->label('is controlled')
                        ->default(false),
                    Forms\Components\Select::make('status')
                        ->label('وضعیت')
                        ->options(['active' => 'فعال', 'inactive' => 'غیرفعال', 'pending' => 'در انتظار', 'approved' => 'تأیید شده', 'rejected' => 'رد شده', 'completed' => 'تکمیل شده', 'cancelled' => 'لغو شده', 'draft' => 'پیش‌نویس', 'open' => 'باز', 'closed' => 'بسته', 'in_progress' => 'در حال انجام', 'suspended' => 'معلق', 'resolved' => 'حل‌شده', 'failed' => 'ناموفق'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('تاریخ‌ها')
                ->schema([
                    Forms\Components\DatePicker::make('expiry_date')
                        ->label('تاریخ انقضا')
                        ->native(false),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('مالی و مقادیر')
                ->schema([
                    Forms\Components\TextInput::make('unit_cost')
                        ->label('unit cost')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('current_stock')
                        ->label('current stock')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('minimum_stock')
                        ->label('minimum stock')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('maximum_stock')
                        ->label('maximum stock')
                        ->numeric()
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('اطلاعات تماس و مکان')
                ->schema([
                    Forms\Components\TextInput::make('storage_location')
                        ->label('storage location')
                        ->numeric()
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
            Section::make('ارتباطات')
                ->schema([
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
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('نام')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('code')
                    ->label('کد')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('وضعیت')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('نوع')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('generic_name')
                    ->label('generic name')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('category')
                    ->label('دسته')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('manufacturer')
                    ->label('تولیدکننده')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('batch_number')
                    ->label('شماره بچ')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('expiry_date')
                    ->label('تاریخ انقضا')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('ایجاد')
                    ->dateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('وضعیت')
                    ->options(['active' => 'فعال', 'inactive' => 'غیرفعال', 'pending' => 'در انتظار', 'approved' => 'تأیید شده', 'rejected' => 'رد شده', 'completed' => 'تکمیل شده', 'cancelled' => 'لغو شده', 'draft' => 'پیش‌نویس', 'open' => 'باز', 'closed' => 'بسته', 'in_progress' => 'در حال انجام', 'suspended' => 'معلق', 'resolved' => 'حل‌شده', 'failed' => 'ناموفق']),
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
            'index' => Pages\ListVaccineDrugs::route('/'),
            'create' => Pages\CreateVaccineDrug::route('/create'),
            'edit' => Pages\EditVaccineDrug::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
