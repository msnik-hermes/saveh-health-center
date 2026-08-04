<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\ChronicDiseaseTrackingResource\Pages;
use App\Models\Center;
use App\Models\ChronicDiseaseTracking;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ChronicDiseaseTrackingResource extends Resource
{
    protected static ?string $model = ChronicDiseaseTracking::class;

    protected static ?string $modelLabel = 'بیماری مزمن';

    protected static ?string $pluralModelLabel = 'ردیابی بیماری‌های مزمن';

    protected static ?string $navigationLabel = 'بیماری‌های مزمن';

    protected static string|\UnitEnum|null $navigationGroup = 'سلامت و درمان';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Heart;

    protected static ?int $navigationSort = 530;

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
                    Forms\Components\Textarea::make('current_medications')
                        ->label('current medications')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Toggle::make('lab_results')
                        ->label('lab results')
                        ->default(false),
                    Forms\Components\Textarea::make('vital_signs')
                        ->label('vital signs')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('hba1c')
                        ->label('hba1c')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('blood_pressure')
                        ->label('فشار خون')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('bmi')
                        ->label('BMI')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('complication_screening')
                        ->label('complication screening')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('referred_to')
                        ->label('referred to')
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('وضعیت و نوع')
                ->schema([
                    Forms\Components\Select::make('disease_type')
                        ->label('disease type')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\DatePicker::make('diagnosis_date')
                        ->label('diagnosis date')
                        ->native(false),
                    Forms\Components\Textarea::make('diagnosis_confirmed_by')
                        ->label('diagnosis confirmed by')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Select::make('control_status')
                        ->label('وضعیت کنترل')
                        ->options(['active' => 'فعال', 'inactive' => 'غیرفعال', 'pending' => 'در انتظار', 'approved' => 'تأیید شده', 'rejected' => 'رد شده', 'completed' => 'تکمیل شده', 'cancelled' => 'لغو شده', 'draft' => 'پیش‌نویس', 'open' => 'باز', 'closed' => 'بسته', 'in_progress' => 'در حال انجام', 'suspended' => 'معلق', 'resolved' => 'حل‌شده', 'failed' => 'ناموفق'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('adherence_level')
                        ->label('adherence level')
                        ->options(['yes' => 'بله', 'no' => 'خیر', 'unknown' => 'نامشخص', 'other' => 'سایر'])
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
            Section::make('تاریخ‌ها')
                ->schema([
                    Forms\Components\DatePicker::make('last_visit_date')
                        ->label('last visit date')
                        ->native(false),
                    Forms\Components\DatePicker::make('next_visit_date')
                        ->label('ویزیت بعدی')
                        ->native(false),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('توضیحات')
                ->schema([
                    Forms\Components\Toggle::make('treatment_plan')
                        ->label('treatment plan')
                        ->default(false),
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
                Tables\Columns\TextColumn::make('disease_type')
                    ->label('disease type')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('diagnosis_date')
                    ->label('diagnosis date')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('diagnosis_confirmed_by')
                    ->label('diagnosis confirmed by')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('current_medications')
                    ->label('current medications')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('last_visit_date')
                    ->label('last visit date')
                    ->date()
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
            'index' => Pages\ListChronicDiseaseTrackings::route('/'),
            'create' => Pages\CreateChronicDiseaseTracking::route('/create'),
            'edit' => Pages\EditChronicDiseaseTracking::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
