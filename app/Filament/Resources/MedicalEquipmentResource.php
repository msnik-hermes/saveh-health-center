<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\MedicalEquipmentResource\Pages;
use App\Models\Center;
use App\Models\Employee;
use App\Models\MedicalEquipment;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MedicalEquipmentResource extends Resource
{
    protected static ?string $model = MedicalEquipment::class;

    protected static ?string $modelLabel = 'تجهیز پزشکی';

    protected static ?string $pluralModelLabel = 'تجهیزات پزشکی';

    protected static ?string $navigationLabel = 'تجهیزات پزشکی';

    protected static string|\UnitEnum|null $navigationGroup = 'مالی و انبار';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Cube;

    protected static ?int $navigationSort = 760;

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
                    Forms\Components\TextInput::make('name')
                        ->label('نام')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('brand')
                        ->label('برند')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('model')
                        ->label('مدل')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('serial_number')
                        ->label('شماره سریال')
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
                    Forms\Components\Select::make('custodian_id')
                        ->label('تحویل‌گیرنده')
                        ->relationship(name: 'custodian', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\Employee $record) => (string) (($record->first_name ?? null) ?: ($record->last_name ?? null) ?: ($record->personnel_code ?? null) ?: ($record->name ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\TextInput::make('room_id')
                        ->label('room')
                        ->maxLength(255),
                ]),
            Section::make('مکان و تماس')
                ->columns(1)
                ->schema([
                    Forms\Components\TextInput::make('location')
                        ->label('مکان')
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
                    Forms\Components\DatePicker::make('purchase_date')
                        ->label('تاریخ خرید')
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
                    Forms\Components\TextInput::make('asset_code')
                        ->label('asset code')
                        ->maxLength(255),
                    Forms\Components\DatePicker::make('last_maintenance')
                        ->label('last maintenance')
                        ->native(false),
                    Forms\Components\TextInput::make('maintenance_interval_months')
                        ->label('maintenance interval months')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\DatePicker::make('next_maintenance')
                        ->label('سرویس بعدی')
                        ->native(false),
                    Forms\Components\TextInput::make('purchase_price')
                        ->label('purchase price')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\DatePicker::make('warranty_end')
                        ->label('warranty end')
                        ->native(false),
                ]),
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
                Tables\Columns\TextColumn::make('category')
                    ->label('دسته')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('brand')
                    ->label('برند')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('model')
                    ->label('مدل')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('serial_number')
                    ->label('شماره سریال')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('asset_code')
                    ->label('asset code')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('purchase_date')
                    ->label('تاریخ خرید')
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
            'index' => Pages\ListMedicalEquipments::route('/'),
            'create' => Pages\CreateMedicalEquipment::route('/create'),
            'edit' => Pages\EditMedicalEquipment::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
