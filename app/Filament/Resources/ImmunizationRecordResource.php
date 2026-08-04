<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\ImmunizationRecordResource\Pages;
use App\Models\Center;
use App\Models\ImmunizationRecord;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ImmunizationRecordResource extends Resource
{
    protected static ?string $model = ImmunizationRecord::class;

    protected static ?string $modelLabel = 'واکسیناسیون';

    protected static ?string $pluralModelLabel = 'سوابق ایمن‌سازی';

    protected static ?string $navigationLabel = 'ایمن‌سازی';

    protected static string|\UnitEnum|null $navigationGroup = 'سلامت و درمان';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::ShieldCheck;

    protected static ?int $navigationSort = 520;

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
            Section::make('اطلاعات اصلی')
                ->schema([
                    Forms\Components\TextInput::make('patient_national_code')
                        ->label('patient national code')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('patient_name')
                        ->label('patient name')
                        ->maxLength(255),
                    Forms\Components\Select::make('patient_gender')
                        ->label('جنسیت بیمار')
                        ->options(['male' => 'مرد', 'female' => 'زن', 'other' => 'سایر', 'unknown' => 'نامشخص'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\TextInput::make('dose_number')
                        ->label('شماره دوز')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('vaccine_name')
                        ->label('نام واکسن')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('batch_number')
                        ->label('شماره بچ')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('administered_by')
                        ->label('تزریق‌کننده')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('injection_site')
                        ->label('injection site')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('side_effects')
                        ->label('side effects')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('guardian_name')
                        ->label('guardian name')
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('تاریخ‌ها')
                ->schema([
                    Forms\Components\DatePicker::make('patient_birth_date')
                        ->label('patient birth date')
                        ->native(false),
                    Forms\Components\DatePicker::make('administration_date')
                        ->label('administration date')
                        ->native(false),
                    Forms\Components\DatePicker::make('next_dose_date')
                        ->label('next dose date')
                        ->native(false),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('وضعیت و نوع')
                ->schema([
                    Forms\Components\Select::make('vaccine_type')
                        ->label('vaccine type')
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
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('اطلاعات تماس و مکان')
                ->schema([
                    Forms\Components\TextInput::make('guardian_phone')
                        ->label('guardian phone')
                        ->tel()
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
                Tables\Columns\TextColumn::make('patient_national_code')
                    ->label('patient national code')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('patient_name')
                    ->label('patient name')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('patient_birth_date')
                    ->label('patient birth date')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('patient_gender')
                    ->label('جنسیت بیمار')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('vaccine_type')
                    ->label('vaccine type')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('dose_number')
                    ->label('شماره دوز')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('vaccine_name')
                    ->label('نام واکسن')
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
            'index' => Pages\ListImmunizationRecords::route('/'),
            'create' => Pages\CreateImmunizationRecord::route('/create'),
            'edit' => Pages\EditImmunizationRecord::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
