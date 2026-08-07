<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\SupplyInventoryResource\Pages;
use App\Models\Center;
use App\Models\SupplyInventory;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SupplyInventoryResource extends Resource
{
    protected static ?string $model = SupplyInventory::class;

    protected static ?string $modelLabel = 'موجودی انبار';

    protected static ?string $pluralModelLabel = 'موجودی انبار';

    protected static ?string $navigationLabel = 'موجودی انبار';

    protected static string|\UnitEnum|null $navigationGroup = 'مالی و انبار';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::ArchiveBox;

    protected static ?int $navigationSort = 730;

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
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('category')
                        ->label('دسته')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
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
                    Forms\Components\DatePicker::make('last_restock_date')
                        ->label('last restock date')
                        ->native(false),
                ]),
            Section::make('مالی و مقادیر')
                ->columns(1)
                ->schema([
                    Forms\Components\TextInput::make('unit_cost')
                        ->label('unit cost')
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
                    Forms\Components\TextInput::make('current_quantity')
                        ->label('current quantity')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('item_name')
                        ->label('item name')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('minimum_quantity')
                        ->label('minimum quantity')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('storage_location')
                        ->label('storage location')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('supplier')
                        ->label('تأمین‌کننده')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('unit')
                        ->label('واحد')
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
                Tables\Columns\TextColumn::make('item_name')
                    ->label('item name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('category')
                    ->label('دسته')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('current_quantity')
                    ->label('current quantity')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('minimum_quantity')
                    ->label('minimum quantity')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('unit')
                    ->label('واحد')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('unit_cost')
                    ->label('unit cost')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('last_restock_date')
                    ->label('last restock date')
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
            'index' => Pages\ListSupplyInventories::route('/'),
            'create' => Pages\CreateSupplyInventory::route('/create'),
            'edit' => Pages\EditSupplyInventory::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
