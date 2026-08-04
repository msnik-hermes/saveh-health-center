<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\CenterUtilityResource\Pages;
use App\Models\Center;
use App\Models\CenterBankAccount;
use App\Models\CenterUtility;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CenterUtilityResource extends Resource
{
    protected static ?string $model = CenterUtility::class;

    protected static ?string $modelLabel = 'انشعاب مرکز';

    protected static ?string $pluralModelLabel = 'انشعابات';

    protected static ?string $navigationLabel = 'انشعابات';

    protected static string|\UnitEnum|null $navigationGroup = 'سازمان';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Bolt;

    protected static ?int $navigationSort = 180;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('ارتباطات')
                ->schema([
                    Forms\Components\Select::make('center_id')
                        ->label('مرکز')
                        ->relationship(name: 'center', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\Center $record) => (string) (($record->name ?? null) ?: ($record->code ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\TextInput::make('bill_id')
                        ->label('bill')
                        ->maxLength(255),
                    Forms\Components\Select::make('bank_account_id')
                        ->label('bank account')
                        ->relationship(name: 'bankAccount', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\CenterBankAccount $record) => (string) (($record->name ?? null) ?: ($record->title ?? null) ?: ($record->code ?? null) ?: ($record->full_name ?? null) ?: ($record->id ?? null) ?: ('#' . $record->getKey())))
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
            Section::make('وضعیت و نوع')
                ->schema([
                    Forms\Components\Select::make('utility_type')
                        ->label('نوع انشعاب')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('meter_type')
                        ->label('meter type')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('payment_status')
                        ->label('payment status')
                        ->options(['active' => 'فعال', 'inactive' => 'غیرفعال', 'pending' => 'در انتظار', 'approved' => 'تأیید شده', 'rejected' => 'رد شده', 'completed' => 'تکمیل شده', 'cancelled' => 'لغو شده', 'draft' => 'پیش‌نویس', 'open' => 'باز', 'closed' => 'بسته', 'in_progress' => 'در حال انجام', 'suspended' => 'معلق', 'resolved' => 'حل‌شده', 'failed' => 'ناموفق'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('internet_type')
                        ->label('internet type')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Toggle::make('has_emergency_power')
                        ->label('has emergency power')
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
            Section::make('اطلاعات اصلی')
                ->schema([
                    Forms\Components\TextInput::make('company')
                        ->label('company')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('meter_number')
                        ->label('شماره کنتور')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('account_number')
                        ->label('شماره حساب')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('last_reading')
                        ->label('last reading')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('avg_consumption')
                        ->label('avg consumption')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('peak_consumption')
                        ->label('peak consumption')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('offpeak_consumption')
                        ->label('offpeak consumption')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('last_payment_tracking')
                        ->label('last payment tracking')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('contract_number')
                        ->label('contract number')
                        ->maxLength(255),
                    Forms\Components\DatePicker::make('contract_start')
                        ->label('contract start')
                        ->native(false),
                    Forms\Components\DatePicker::make('contract_end')
                        ->label('contract end')
                        ->native(false),
                    Forms\Components\TextInput::make('internet_speed')
                        ->label('internet speed')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('internet_ip')
                        ->label('internet ip')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('internet_modem')
                        ->label('internet modem')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('internet_firewall')
                        ->label('internet firewall')
                        ->maxLength(255),
                    Forms\Components\Toggle::make('internet_vpn')
                        ->label('internet vpn')
                        ->default(false),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('اطلاعات تماس و مکان')
                ->schema([
                    Forms\Components\TextInput::make('capacity')
                        ->label('ظرفیت')
                        ->numeric()
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('تاریخ‌ها')
                ->schema([
                    Forms\Components\TextInput::make('monthly_cost')
                        ->label('هزینه ماهانه')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\DatePicker::make('last_reading_date')
                        ->label('last reading date')
                        ->native(false),
                    Forms\Components\DatePicker::make('last_payment_date')
                        ->label('last payment date')
                        ->native(false),
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
                Tables\Columns\TextColumn::make('utility_type')
                    ->label('نوع انشعاب')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('company')
                    ->label('company')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('meter_number')
                    ->label('شماره کنتور')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('bill_id')
                    ->label('bill')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('account_number')
                    ->label('شماره حساب')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('meter_type')
                    ->label('meter type')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('capacity')
                    ->label('ظرفیت')
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
            'index' => Pages\ListCenterUtilities::route('/'),
            'create' => Pages\CreateCenterUtility::route('/create'),
            'edit' => Pages\EditCenterUtility::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
