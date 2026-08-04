<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Models\Center;
use App\Models\Employee;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $modelLabel = 'کارمند';

    protected static ?string $pluralModelLabel = 'کارکنان';

    protected static ?string $navigationLabel = 'کارکنان';

    protected static string|\UnitEnum|null $navigationGroup = 'منابع انسانی';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Users;

    protected static ?int $navigationSort = 210;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('اطلاعات اصلی')
                ->schema([
                    Forms\Components\TextInput::make('personnel_code')
                        ->label('کد پرسنلی')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('first_name')
                        ->label('نام')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('last_name')
                        ->label('نام خانوادگی')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('father_name')
                        ->label('نام پدر')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('national_code')
                        ->label('کد ملی')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('id_card_number')
                        ->label('id card number')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('id_card_serial')
                        ->label('id card serial')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('birth_place')
                        ->label('محل تولد')
                        ->maxLength(255),
                    Forms\Components\Select::make('gender')
                        ->label('جنسیت')
                        ->options(['male' => 'مرد', 'female' => 'زن', 'other' => 'سایر', 'unknown' => 'نامشخص'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\TextInput::make('children_count')
                        ->label('children count')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('nationality')
                        ->label('nationality')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('religion')
                        ->label('religion')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('height_cm')
                        ->label('height cm')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('weight_kg')
                        ->label('weight kg')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('photo')
                        ->label('photo')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('signature')
                        ->label('signature')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('job_title')
                        ->label('سمت')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('position')
                        ->label('position')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('department')
                        ->label('بخش')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('education_degree')
                        ->label('education degree')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('education_field')
                        ->label('education field')
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('تاریخ‌ها')
                ->schema([
                    Forms\Components\DatePicker::make('birth_date')
                        ->label('تاریخ تولد')
                        ->native(false),
                    Forms\Components\DatePicker::make('employment_date')
                        ->label('employment date')
                        ->native(false),
                    Forms\Components\DatePicker::make('end_date')
                        ->label('تاریخ پایان')
                        ->native(false),
                    Forms\Components\DatePicker::make('probation_end_date')
                        ->label('probation end date')
                        ->native(false),
                    Forms\Components\DatePicker::make('contract_end_date')
                        ->label('پایان قرارداد')
                        ->native(false),
                    Forms\Components\DatePicker::make('retirement_date')
                        ->label('retirement date')
                        ->native(false),
                    Forms\Components\TextInput::make('years_of_service')
                        ->label('سنوات')
                        ->numeric()
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('وضعیت و نوع')
                ->schema([
                    Forms\Components\Select::make('marital_status')
                        ->label('وضعیت تأهل')
                        ->options(['single' => 'مجرد', 'married' => 'متأهل', 'divorced' => 'مطلقه', 'widowed' => 'بیوه'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('blood_type')
                        ->label('گروه خونی')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('military_service_status')
                        ->label('military service status')
                        ->options(['active' => 'فعال', 'inactive' => 'غیرفعال', 'pending' => 'در انتظار', 'approved' => 'تأیید شده', 'rejected' => 'رد شده', 'completed' => 'تکمیل شده', 'cancelled' => 'لغو شده', 'draft' => 'پیش‌نویس', 'open' => 'باز', 'closed' => 'بسته', 'in_progress' => 'در حال انجام', 'suspended' => 'معلق', 'resolved' => 'حل‌شده', 'failed' => 'ناموفق'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Toggle::make('has_disability')
                        ->label('has disability')
                        ->default(false),
                    Forms\Components\Select::make('disability_type')
                        ->label('disability type')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('employment_type')
                        ->label('نوع استخدام')
                        ->options(['official' => 'رسمی', 'contract' => 'قراردادی', 'corporate' => 'شرکتی', 'conscript' => 'طرحی', 'temporary' => 'موقت', 'volunteer' => 'داوطلب'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('service_type')
                        ->label('نوع خدمت')
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
                    Forms\Components\Toggle::make('is_laborer')
                        ->label('is laborer')
                        ->default(false),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('اطلاعات تماس و مکان')
                ->schema([
                    Forms\Components\TextInput::make('ethnicity')
                        ->label('ethnicity')
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('ارتباطات')
                ->schema([
                    Forms\Components\Select::make('center_id')
                        ->label('مرکز')
                        ->relationship(name: 'center', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\Center $record) => (string) (($record->name ?? null) ?: ($record->code ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->required(),
                    Forms\Components\Select::make('supervisor_id')
                        ->label('سرپرست')
                        ->relationship(name: 'supervisor', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\Employee $record) => (string) (($record->first_name ?? null) ?: ($record->last_name ?? null) ?: ($record->personnel_code ?? null) ?: ($record->name ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),
                ])
                ->columns(2)
                ->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->label('نام')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->label('نام خانوادگی')
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
                Tables\Columns\TextColumn::make('personnel_code')
                    ->label('کد پرسنلی')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('father_name')
                    ->label('نام پدر')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('national_code')
                    ->label('کد ملی')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('id_card_number')
                    ->label('id card number')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('id_card_serial')
                    ->label('id card serial')
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
