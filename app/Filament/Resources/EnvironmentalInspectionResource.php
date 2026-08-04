<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\EnvironmentalInspectionResource\Pages;
use App\Models\Center;
use App\Models\Employee;
use App\Models\EnvironmentalEstablishment;
use App\Models\EnvironmentalInspection;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EnvironmentalInspectionResource extends Resource
{
    protected static ?string $model = EnvironmentalInspection::class;

    protected static ?string $modelLabel = 'بازرسی محیط';

    protected static ?string $pluralModelLabel = 'بازرسی‌های بهداشت محیط';

    protected static ?string $navigationLabel = 'بازرسی محیط';

    protected static string|\UnitEnum|null $navigationGroup = 'بازرسی و ایمنی';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::MagnifyingGlass;

    protected static ?int $navigationSort = 650;

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
                    Forms\Components\Select::make('center_id')
                        ->label('مرکز')
                        ->relationship(name: 'center', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\Center $record) => (string) (($record->name ?? null) ?: ($record->code ?? null) ?: ('#' . $record->getKey())))
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
                    Forms\Components\Select::make('inspection_type')
                        ->label('نوع بازرسی')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\TextInput::make('facility_conditions_score')
                        ->label('facility conditions score')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\Select::make('compliance_level')
                        ->label('compliance level')
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
                    Forms\Components\DatePicker::make('inspection_date')
                        ->label('تاریخ بازرسی')
                        ->native(false),
                    Forms\Components\DatePicker::make('follow_up_date')
                        ->label('follow up date')
                        ->native(false),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('اطلاعات اصلی')
                ->schema([
                    Forms\Components\TextInput::make('personal_hygiene_score')
                        ->label('personal hygiene score')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('food_safety_score')
                        ->label('food safety score')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('cleaning_sanitation_score')
                        ->label('cleaning sanitation score')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('pest_control_score')
                        ->label('pest control score')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('water_quality_score')
                        ->label('water quality score')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('chemical_safety_score')
                        ->label('chemical safety score')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('waste_management_score')
                        ->label('waste management score')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('overall_score')
                        ->label('امتیاز کل')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('critical_violations')
                        ->label('critical violations')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('major_violations')
                        ->label('major violations')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('minor_violations')
                        ->label('minor violations')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('violations_detail')
                        ->label('violations detail')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('images')
                        ->label('تصاویر')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('corrective_actions')
                        ->label('corrective actions')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Toggle::make('follow_up_needed')
                        ->label('follow up needed')
                        ->default(false),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('توضیحات')
                ->schema([
                    Forms\Components\Textarea::make('positive_findings')
                        ->label('positive findings')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('recommendations')
                        ->label('توصیه‌ها')
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
                Tables\Columns\TextColumn::make('center.name')
                    ->label('مرکز')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('inspection_date')
                    ->label('تاریخ بازرسی')
                    ->searchable()
                    ->sortable()
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('establishment.name')
                    ->label('establishment')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('inspector.first_name')
                    ->label('بازرس')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('inspection_type')
                    ->label('نوع بازرسی')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('personal_hygiene_score')
                    ->label('personal hygiene score')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('facility_conditions_score')
                    ->label('facility conditions score')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('food_safety_score')
                    ->label('food safety score')
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
                Tables\Filters\SelectFilter::make('establishment_id')
                    ->label('establishment')
                    ->relationship('establishment', 'id')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\EnvironmentalEstablishment $record) => (string) ((($record->name ?? null) ?: ($record->title ?? null) ?: ($record->code ?? null) ?: ($record->full_name ?? null) ?: ($record->id ?? null)) ?: ('#' . $record->getKey())))
                    ->searchable()
                    ->preload(),
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
            'index' => Pages\ListEnvironmentalInspections::route('/'),
            'create' => Pages\CreateEnvironmentalInspection::route('/create'),
            'edit' => Pages\EditEnvironmentalInspection::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
