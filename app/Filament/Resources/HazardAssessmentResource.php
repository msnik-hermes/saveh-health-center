<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\HazardAssessmentResource\Pages;
use App\Models\Company;
use App\Models\HazardAssessment;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class HazardAssessmentResource extends Resource
{
    protected static ?string $model = HazardAssessment::class;

    protected static ?string $modelLabel = 'ارزیابی خطر';

    protected static ?string $pluralModelLabel = 'ارزیابی‌های خطر';

    protected static ?string $navigationLabel = 'ارزیابی خطر';

    protected static string|\UnitEnum|null $navigationGroup = 'بازرسی و ایمنی';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::ExclamationTriangle;

    protected static ?int $navigationSort = 630;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('اطلاعات اصلی')
                ->schema([
                    Forms\Components\TextInput::make('company_name')
                        ->label('company name')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('assessor_name')
                        ->label('assessor name')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('assessor_qualifications')
                        ->label('assessor qualifications')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('job_title_assessed')
                        ->label('job title assessed')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('workers_in_job')
                        ->label('workers in job')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('daily_work_hours')
                        ->label('daily work hours')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('weekly_work_days')
                        ->label('weekly work days')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('hazard_categories')
                        ->label('hazard categories')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('physical_hazards')
                        ->label('physical hazards')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('chemical_hazards')
                        ->label('chemical hazards')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('biological_hazards')
                        ->label('biological hazards')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('ergonomic_hazards')
                        ->label('ergonomic hazards')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('psychosocial_hazards')
                        ->label('psychosocial hazards')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('control_measures')
                        ->label('اقدامات کنترلی')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('assessment_report')
                        ->label('assessment report')
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('ارتباطات')
                ->schema([
                    Forms\Components\Select::make('company_id')
                        ->label('شرکت')
                        ->relationship(name: 'company', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\Company $record) => (string) (($record->name ?? null) ?: ($record->registration_number ?? null) ?: ('#' . $record->getKey())))
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
            Section::make('تاریخ‌ها')
                ->schema([
                    Forms\Components\DatePicker::make('assessment_date')
                        ->label('assessment date')
                        ->native(false),
                    Forms\Components\DatePicker::make('review_date')
                        ->label('تاریخ بازنگری')
                        ->native(false),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('وضعیت و نوع')
                ->schema([
                    Forms\Components\Select::make('risk_category')
                        ->label('risk category')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('overall_risk')
                        ->label('overall risk')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('توضیحات')
                ->schema([
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
                Tables\Columns\TextColumn::make('company.name')
                    ->label('شرکت')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('company_name')
                    ->label('company name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('assessment_date')
                    ->label('assessment date')
                    ->searchable()
                    ->sortable()
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('assessor_name')
                    ->label('assessor name')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('assessor_qualifications')
                    ->label('assessor qualifications')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('job_title_assessed')
                    ->label('job title assessed')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('workers_in_job')
                    ->label('workers in job')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('daily_work_hours')
                    ->label('daily work hours')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('weekly_work_days')
                    ->label('weekly work days')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('ایجاد')
                    ->dateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('company_id')
                    ->label('شرکت')
                    ->relationship('company', 'id')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\Company $record) => (string) ((($record->name ?? null) ?: ($record->registration_number ?? null)) ?: ('#' . $record->getKey())))
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
            'index' => Pages\ListHazardAssessments::route('/'),
            'create' => Pages\CreateHazardAssessment::route('/create'),
            'edit' => Pages\EditHazardAssessment::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
