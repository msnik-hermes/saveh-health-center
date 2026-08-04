<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\HealthPermitResource\Pages;
use App\Models\Employee;
use App\Models\EnvironmentalEstablishment;
use App\Models\HealthPermit;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class HealthPermitResource extends Resource
{
    protected static ?string $model = HealthPermit::class;

    protected static ?string $modelLabel = 'مجوز بهداشتی';

    protected static ?string $pluralModelLabel = 'مجوزهای بهداشتی';

    protected static ?string $navigationLabel = 'مجوزهای بهداشتی';

    protected static string|\UnitEnum|null $navigationGroup = 'بازرسی و ایمنی';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::CheckBadge;

    protected static ?int $navigationSort = 660;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('ارتباطات')
                ->schema([
                    Forms\Components\Select::make('establishment_id')
                        ->label('establishment')
                        ->relationship(name: 'establishment', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\EnvironmentalEstablishment $record) => (string) (($record->name ?? null) ?: ($record->title ?? null) ?: ($record->code ?? null) ?: ($record->full_name ?? null) ?: ($record->id ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('inspector_id')
                        ->label('بازرس')
                        ->relationship(name: 'inspector', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\Employee $record) => (string) (($record->first_name ?? null) ?: ($record->last_name ?? null) ?: ($record->personnel_code ?? null) ?: ($record->name ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('previous_permit_id')
                        ->label('previous permit')
                        ->relationship(name: 'previousPermit', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\HealthPermit $record) => (string) (($record->name ?? null) ?: ($record->title ?? null) ?: ($record->code ?? null) ?: ($record->full_name ?? null) ?: ($record->id ?? null) ?: ('#' . $record->getKey())))
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
                    Forms\Components\Select::make('permit_type')
                        ->label('نوع مجوز')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\TextInput::make('conditions')
                        ->label('conditions')
                        ->maxLength(255),
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
                    Forms\Components\TextInput::make('permit_number')
                        ->label('permit number')
                        ->maxLength(255),
                    Forms\Components\Toggle::make('issuing_authority')
                        ->label('issuing authority')
                        ->default(false),
                    Forms\Components\TextInput::make('fee_paid')
                        ->label('fee paid')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('payment_reference')
                        ->label('payment reference')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('renewal_count')
                        ->label('renewal count')
                        ->numeric()
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('تاریخ‌ها')
                ->schema([
                    Forms\Components\Toggle::make('issue_date')
                        ->label('تاریخ صدور')
                        ->default(false),
                    Forms\Components\DatePicker::make('expiry_date')
                        ->label('تاریخ انقضا')
                        ->native(false),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('توضیحات')
                ->schema([
                    Forms\Components\Textarea::make('suspension_reason')
                        ->label('suspension reason')
                        ->rows(3)
                        ->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('establishment.name')
                    ->label('establishment')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('permit_type')
                    ->label('نوع مجوز')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('permit_number')
                    ->label('permit number')
                    ->toggleable(),
                Tables\Columns\IconColumn::make('issue_date')
                    ->label('تاریخ صدور')
                    ->boolean()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('expiry_date')
                    ->label('تاریخ انقضا')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('conditions')
                    ->label('conditions')
                    ->toggleable(),
                Tables\Columns\IconColumn::make('issuing_authority')
                    ->label('issuing authority')
                    ->boolean()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('inspector.first_name')
                    ->label('بازرس')
                    ->searchable()
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
                Tables\Filters\SelectFilter::make('establishment_id')
                    ->label('establishment')
                    ->relationship('establishment', 'id')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\EnvironmentalEstablishment $record) => (string) ((($record->name ?? null) ?: ($record->title ?? null) ?: ($record->code ?? null) ?: ($record->full_name ?? null) ?: ($record->id ?? null)) ?: ('#' . $record->getKey())))
                    ->searchable()
                    ->preload(),
                Tables\Filters\TernaryFilter::make('issue_date')->label('تاریخ صدور'),
                Tables\Filters\TernaryFilter::make('issuing_authority')->label('issuing authority'),
                Tables\Filters\SelectFilter::make('inspector_id')
                    ->label('بازرس')
                    ->relationship('inspector', 'id')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\Employee $record) => (string) ((($record->first_name ?? null) ?: ($record->last_name ?? null) ?: ($record->personnel_code ?? null) ?: ($record->name ?? null)) ?: ('#' . $record->getKey())))
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
            'index' => Pages\ListHealthPermits::route('/'),
            'create' => Pages\CreateHealthPermit::route('/create'),
            'edit' => Pages\EditHealthPermit::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
