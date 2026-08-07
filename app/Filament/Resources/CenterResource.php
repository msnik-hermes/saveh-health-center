<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\CenterResource\Pages;
use App\Models\Center;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CenterResource extends Resource
{
    protected static ?string $model = Center::class;

    protected static ?string $modelLabel = 'مرکز';

    protected static ?string $pluralModelLabel = 'مراکز';

    protected static ?string $navigationLabel = 'مراکز';

    protected static string|\UnitEnum|null $navigationGroup = 'سازمان';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::BuildingOffice2;

    protected static ?int $navigationSort = 110;

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
                    Forms\Components\TextInput::make('code')
                        ->label('کد')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('name')
                        ->label('نام')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('university')
                        ->label('دانشگاه')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('population_served')
                        ->label('جمعیت تحت پوشش')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('license_number')
                        ->label('شماره مجوز')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->label('ایمیل')
                        ->email()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('logo')
                        ->label('لوگو')
                        ->maxLength(255),
                ]),
            Section::make('ارتباطات')
                ->columns(1)
                ->schema([
                    Forms\Components\Select::make('parent_id')
                        ->label('مرکز والد')
                        ->relationship(name: 'parent', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\Center $record) => (string) (($record->name ?? null) ?: ($record->code ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),
                ]),
            Section::make('مکان و تماس')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('province')
                        ->label('استان')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('city')
                        ->label('شهر')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('district')
                        ->label('منطقه')
                        ->maxLength(255),
                    Forms\Components\Textarea::make('address')
                        ->label('آدرس')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('postal_code')
                        ->label('کد پستی')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('gps_lat')
                        ->label('عرض جغرافیایی')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('gps_lng')
                        ->label('طول جغرافیایی')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('phone')
                        ->label('تلفن')
                        ->tel()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('fax')
                        ->label('فکس')
                        ->tel()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('website')
                        ->label('وب‌سایت')
                        ->maxLength(255),
                    Forms\Components\DateTimePicker::make('working_hours_start')
                        ->label('ساعت شروع')
                        ->native(false)
                        ->seconds(false),
                    Forms\Components\DateTimePicker::make('working_hours_end')
                        ->label('ساعت پایان')
                        ->native(false)
                        ->seconds(false),
                    Forms\Components\TextInput::make('working_days')
                        ->label('روزهای کاری')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('emergency_hours')
                        ->label('ساعات اضطراری')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('area_sqm')
                        ->label('مساحت (م²)')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('floors')
                        ->label('تعداد طبقات')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('rooms_count')
                        ->label('تعداد اتاق')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('parking_spaces')
                        ->label('پارکینگ')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('generator_power_kw')
                        ->label('قدرت ژنراتور (کیلووات)')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\Toggle::make('has_generator')
                        ->label('ژنراتور')
                        ->default(false),
                    Forms\Components\Toggle::make('has_cctv')
                        ->label('دوربین مداربسته')
                        ->default(false),
                    Forms\Components\Toggle::make('has_elevator')
                        ->label('آسانسور')
                        ->default(false),
                    Forms\Components\Toggle::make('has_fire_system')
                        ->label('سیستم آتش‌نشانی')
                        ->default(false),
                ]),
            Section::make('وضعیت و نوع')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('accreditation_level')
                        ->label('سطح اعتباربخشی')
                        ->options(['yes' => 'بله', 'no' => 'خیر', 'unknown' => 'نامشخص', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('building_type')
                        ->label('نوع ساختمان')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('level')
                        ->label('سطح')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('service_area_type')
                        ->label('نوع حوزه خدمت')
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
                    Forms\Components\Select::make('type')
                        ->label('نوع')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                ]),
            Section::make('تاریخ‌ها')
                ->columns(2)
                ->schema([
                    Forms\Components\DatePicker::make('established_date')
                        ->label('تاریخ تأسیس')
                        ->native(false),
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
                Tables\Columns\TextColumn::make('phone')
                    ->label('تلفن')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('city')
                    ->label('شهر')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('ایمیل')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('parent.name')
                    ->label('مرکز والد')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('level')
                    ->label('سطح')
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
                Tables\Filters\SelectFilter::make('parent_id')
                    ->label('مرکز والد')
                    ->relationship('parent', 'id')
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
            'index' => Pages\ListCenters::route('/'),
            'create' => Pages\CreateCenter::route('/create'),
            'edit' => Pages\EditCenter::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
