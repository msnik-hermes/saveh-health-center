<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\PregnantWomanResource\Pages;
use App\Models\Center;
use App\Models\PregnantWoman;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PregnantWomanResource extends Resource
{
    protected static ?string $model = PregnantWoman::class;

    protected static ?string $modelLabel = 'زن باردار';

    protected static ?string $pluralModelLabel = 'زنان باردار';

    protected static ?string $navigationLabel = 'زنان باردار';

    protected static string|\UnitEnum|null $navigationGroup = 'سلامت خانواده';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Heart;

    protected static ?int $navigationSort = 410;

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
                        ->required(),
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
                    Forms\Components\TextInput::make('national_code')
                        ->label('کد ملی')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('full_name')
                        ->label('نام کامل')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('age')
                        ->label('age')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('husband_name')
                        ->label('husband name')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('village')
                        ->label('village')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('gravida')
                        ->label('gravida')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('parity')
                        ->label('parity')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('abortion_count')
                        ->label('abortion count')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('living_children')
                        ->label('living children')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('rh_factor')
                        ->label('rh factor')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('medical_history')
                        ->label('medical history')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('current_medications')
                        ->label('current medications')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('tetanus_vaccination')
                        ->label('tetanus vaccination')
                        ->maxLength(255),
                    Forms\Components\Toggle::make('iron_supplementation')
                        ->label('iron supplementation')
                        ->default(false),
                    Forms\Components\Toggle::make('folic_acid')
                        ->label('folic acid')
                        ->default(false),
                    Forms\Components\TextInput::make('anc_visits_count')
                        ->label('anc visits count')
                        ->numeric()
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('اطلاعات تماس و مکان')
                ->schema([
                    Forms\Components\TextInput::make('phone')
                        ->label('تلفن')
                        ->tel()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('address')
                        ->label('آدرس')
                        ->rows(3)
                        ->columnSpanFull(),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('تاریخ‌ها')
                ->schema([
                    Forms\Components\DatePicker::make('lmp_date')
                        ->label('تاریخ LMP')
                        ->native(false),
                    Forms\Components\DatePicker::make('edd_date')
                        ->label('تاریخ زایمان تقریبی')
                        ->native(false),
                    Forms\Components\DatePicker::make('registration_date')
                        ->label('registration date')
                        ->native(false),
                    Forms\Components\DatePicker::make('first_anc_date')
                        ->label('first anc date')
                        ->native(false),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('وضعیت و نوع')
                ->schema([
                    Forms\Components\Select::make('blood_type')
                        ->label('گروه خونی')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Textarea::make('risk_factors')
                        ->label('عوامل خطر')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Select::make('status')
                        ->label('وضعیت')
                        ->options(['active' => 'فعال', 'inactive' => 'غیرفعال', 'pending' => 'در انتظار', 'approved' => 'تأیید شده', 'rejected' => 'رد شده', 'completed' => 'تکمیل شده', 'cancelled' => 'لغو شده', 'draft' => 'پیش‌نویس', 'open' => 'باز', 'closed' => 'بسته', 'in_progress' => 'در حال انجام', 'suspended' => 'معلق', 'resolved' => 'حل‌شده', 'failed' => 'ناموفق'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
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
                Tables\Columns\TextColumn::make('full_name')
                    ->label('نام کامل')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('وضعیت')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('تلفن')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('center.name')
                    ->label('مرکز')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('national_code')
                    ->label('کد ملی')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('age')
                    ->label('age')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('husband_name')
                    ->label('husband name')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('address')
                    ->label('آدرس')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('village')
                    ->label('village')
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
            'index' => Pages\ListPregnantWomen::route('/'),
            'create' => Pages\CreatePregnantWoman::route('/create'),
            'edit' => Pages\EditPregnantWoman::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
