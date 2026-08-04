<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\SuicideStatisticResource\Pages;
use App\Models\Center;
use App\Models\SuicideStatistic;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SuicideStatisticResource extends Resource
{
    protected static ?string $model = SuicideStatistic::class;

    protected static ?string $modelLabel = 'آمار خودکشی';

    protected static ?string $pluralModelLabel = 'آمار خودکشی';

    protected static ?string $navigationLabel = 'آمار خودکشی';

    protected static string|\UnitEnum|null $navigationGroup = 'سلامت و درمان';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::PresentationChartLine;

    protected static ?int $navigationSort = 580;

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
                    Forms\Components\TextInput::make('case_id')
                        ->label('شناسه پرونده')
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('اطلاعات اصلی')
                ->schema([
                    Forms\Components\TextInput::make('full_name')
                        ->label('نام کامل')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('national_code')
                        ->label('کد ملی')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('age')
                        ->label('age')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\Select::make('gender')
                        ->label('جنسیت')
                        ->options(['male' => 'مرد', 'female' => 'زن', 'other' => 'سایر', 'unknown' => 'نامشخص'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\TextInput::make('occupation')
                        ->label('occupation')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('children_count')
                        ->label('children count')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('family_size')
                        ->label('family size')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('neighborhood')
                        ->label('neighborhood')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('urban_rural')
                        ->label('شهری/روستایی')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('method')
                        ->label('روش')
                        ->maxLength(255),
                    Forms\Components\Toggle::make('premeditated')
                        ->label('premeditated')
                        ->default(false),
                    Forms\Components\Toggle::make('prior_communication')
                        ->label('prior communication')
                        ->default(false),
                    Forms\Components\Toggle::make('witnesses_present')
                        ->label('witnesses present')
                        ->default(false),
                    Forms\Components\DatePicker::make('prior_attempts')
                        ->label('prior attempts')
                        ->native(false),
                    Forms\Components\Textarea::make('mental_health_diagnosis')
                        ->label('mental health diagnosis')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Toggle::make('substance_use')
                        ->label('substance use')
                        ->default(false),
                    Forms\Components\Textarea::make('recent_life_events')
                        ->label('recent life events')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('suicidal_intent')
                        ->label('suicidal intent')
                        ->maxLength(255),
                    Forms\Components\Toggle::make('suicidal_plan')
                        ->label('suicidal plan')
                        ->default(false),
                    Forms\Components\TextInput::make('hopelessness_score')
                        ->label('hopelessness score')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('depression_score')
                        ->label('depression score')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('anxiety_score')
                        ->label('anxiety score')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\Toggle::make('survived')
                        ->label('survived')
                        ->default(false),
                    Forms\Components\Toggle::make('hospital_admission')
                        ->label('hospital admission')
                        ->default(false),
                    Forms\Components\TextInput::make('hospital_name')
                        ->label('hospital name')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('length_of_stay')
                        ->label('length of stay')
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
                    Forms\Components\Select::make('education_level')
                        ->label('education level')
                        ->options(['yes' => 'بله', 'no' => 'خیر', 'unknown' => 'نامشخص', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('employment_status')
                        ->label('employment status')
                        ->options(['active' => 'فعال', 'inactive' => 'غیرفعال', 'pending' => 'در انتظار', 'approved' => 'تأیید شده', 'rejected' => 'رد شده', 'completed' => 'تکمیل شده', 'cancelled' => 'لغو شده', 'draft' => 'پیش‌نویس', 'open' => 'باز', 'closed' => 'بسته', 'in_progress' => 'در حال انجام', 'suspended' => 'معلق', 'resolved' => 'حل‌شده', 'failed' => 'ناموفق'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('income_level')
                        ->label('سطح درآمد')
                        ->options(['yes' => 'بله', 'no' => 'خیر', 'unknown' => 'نامشخص', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('injury_severity')
                        ->label('injury severity')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('اطلاعات تماس و مکان')
                ->schema([
                    Forms\Components\TextInput::make('district')
                        ->label('منطقه')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('city_village')
                        ->label('city village')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('event_location')
                        ->label('event location')
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('تاریخ‌ها')
                ->schema([
                    Forms\Components\DatePicker::make('event_date')
                        ->label('event date')
                        ->native(false),
                    Forms\Components\DateTimePicker::make('event_time')
                        ->label('event time')
                        ->native(false)
                        ->seconds(false),
                    Forms\Components\DatePicker::make('prior_attempt_dates')
                        ->label('prior attempt dates')
                        ->native(false),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('توضیحات')
                ->schema([
                    Forms\Components\Toggle::make('psychiatric_treatment')
                        ->label('psychiatric treatment')
                        ->default(false),
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
                Tables\Columns\TextColumn::make('center.name')
                    ->label('مرکز')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('case_id')
                    ->label('شناسه پرونده')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('national_code')
                    ->label('کد ملی')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('age')
                    ->label('age')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('gender')
                    ->label('جنسیت')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('marital_status')
                    ->label('وضعیت تأهل')
                    ->badge()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('education_level')
                    ->label('education level')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('occupation')
                    ->label('occupation')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('ایجاد')
                    ->dateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('center_id')
                    ->label('مرکز')
                    ->relationship('center', 'id')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\Center $record) => (string) ((($record->name ?? null) ?: ($record->code ?? null)) ?: ('#' . $record->getKey())))
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('marital_status')
                    ->label('وضعیت تأهل')
                    ->options(['single' => 'مجرد', 'married' => 'متأهل', 'divorced' => 'مطلقه', 'widowed' => 'بیوه']),
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
            'index' => Pages\ListSuicideStatistics::route('/'),
            'create' => Pages\CreateSuicideStatistic::route('/create'),
            'edit' => Pages\EditSuicideStatistic::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
