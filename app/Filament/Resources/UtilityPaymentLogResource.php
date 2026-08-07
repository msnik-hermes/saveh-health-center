<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\UtilityPaymentLogResource\Pages;
use App\Models\CenterBankAccount;
use App\Models\CenterUtility;
use App\Models\UtilityPaymentLog;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UtilityPaymentLogResource extends Resource
{
    protected static ?string $model = UtilityPaymentLog::class;

    protected static ?string $modelLabel = 'پرداخت انشعاب';

    protected static ?string $pluralModelLabel = 'پرداخت‌های انشعاب';

    protected static ?string $navigationLabel = 'پرداخت انشعاب';

    protected static string|\UnitEnum|null $navigationGroup = 'مالی و انبار';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::ReceiptPercent;

    protected static ?int $navigationSort = 770;

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
                    Forms\Components\Select::make('bank_account_id')
                        ->label('bank account')
                        ->relationship(name: 'bankAccount', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\CenterBankAccount $record) => (string) (($record->name ?? null) ?: ($record->title ?? null) ?: ($record->code ?? null) ?: ($record->full_name ?? null) ?: ($record->id ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('utility_id')
                        ->label('utility')
                        ->relationship(name: 'utility', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\CenterUtility $record) => (string) (($record->name ?? null) ?: ($record->title ?? null) ?: ($record->code ?? null) ?: ($record->full_name ?? null) ?: ($record->id ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),
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
            Section::make('مالی و مقادیر')
                ->columns(1)
                ->schema([
                    Forms\Components\TextInput::make('amount')
                        ->label('مبلغ')
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
                    Forms\Components\Toggle::make('auto_paid')
                        ->label('auto paid')
                        ->default(false),
                    Forms\Components\TextInput::make('payment_method')
                        ->label('روش پرداخت')
                        ->maxLength(255),
                    Forms\Components\Textarea::make('response_data')
                        ->label('response data')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('tracking_number')
                        ->label('tracking number')
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
                Tables\Columns\TextColumn::make('amount')
                    ->label('مبلغ')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('utility.name')
                    ->label('utility')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('bankAccount.name')
                    ->label('bank account')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('tracking_number')
                    ->label('tracking number')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('روش پرداخت')
                    ->toggleable(),
                Tables\Columns\IconColumn::make('auto_paid')
                    ->label('auto paid')
                    ->boolean()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('response_data')
                    ->label('response data')
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
                Tables\Filters\SelectFilter::make('utility_id')
                    ->label('utility')
                    ->relationship('utility', 'id')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\CenterUtility $record) => (string) ((($record->name ?? null) ?: ($record->title ?? null) ?: ($record->code ?? null) ?: ($record->full_name ?? null) ?: ($record->id ?? null)) ?: ('#' . $record->getKey())))
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('bank_account_id')
                    ->label('bank account')
                    ->relationship('bankAccount', 'id')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\CenterBankAccount $record) => (string) ((($record->name ?? null) ?: ($record->title ?? null) ?: ($record->code ?? null) ?: ($record->full_name ?? null) ?: ($record->id ?? null)) ?: ('#' . $record->getKey())))
                    ->searchable()
                    ->preload(),
                Tables\Filters\TernaryFilter::make('auto_paid')->label('auto paid'),
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
            'index' => Pages\ListUtilityPaymentLogs::route('/'),
            'create' => Pages\CreateUtilityPaymentLog::route('/create'),
            'edit' => Pages\EditUtilityPaymentLog::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
