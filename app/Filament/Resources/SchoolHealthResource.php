<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\SchoolHealthResource\Pages;
use App\Models\Center;
use App\Models\SchoolHealth;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SchoolHealthResource extends Resource
{
    protected static ?string $model = SchoolHealth::class;

    protected static ?string $modelLabel = 'بهداشت مدارس';

    protected static ?string $pluralModelLabel = 'بهداشت مدارس';

    protected static ?string $navigationLabel = 'بهداشت مدارس';

    protected static string|\UnitEnum|null $navigationGroup = 'سلامت خانواده';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::AcademicCap;

    protected static ?int $navigationSort = 440;

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
                    Forms\Components\TextInput::make('school_name')
                        ->label('نام مدرسه')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('school_code')
                        ->label('school code')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('student_population')
                        ->label('student population')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('male_count')
                        ->label('male count')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('female_count')
                        ->label('female count')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('students_screened')
                        ->label('students screened')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('vision_problems')
                        ->label('vision problems')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('hearing_problems')
                        ->label('hearing problems')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('dental_problems')
                        ->label('dental problems')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('bmi_underweight')
                        ->label('bmi underweight')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('bmi_normal')
                        ->label('bmi normal')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('bmi_overweight')
                        ->label('bmi overweight')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('bmi_obese')
                        ->label('bmi obese')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('growth_problems')
                        ->label('growth problems')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('anemia_cases')
                        ->label('anemia cases')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('referrals_made')
                        ->label('referrals made')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('education_sessions')
                        ->label('education sessions')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('topics_covered')
                        ->label('topics covered')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('students_reached')
                        ->label('students reached')
                        ->numeric()
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('وضعیت و نوع')
                ->schema([
                    Forms\Components\Select::make('school_type')
                        ->label('نوع مدرسه')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('screening_type')
                        ->label('screening type')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Toggle::make('referral_outcomes')
                        ->label('referral outcomes')
                        ->default(false),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('اطلاعات تماس و مکان')
                ->schema([
                    Forms\Components\TextInput::make('school_location')
                        ->label('school location')
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('تاریخ‌ها')
                ->schema([
                    Forms\Components\DatePicker::make('screening_date')
                        ->label('تاریخ غربالگری')
                        ->native(false),
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
                Tables\Columns\TextColumn::make('center.name')
                    ->label('مرکز')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('school_name')
                    ->label('نام مدرسه')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('school_code')
                    ->label('school code')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('school_type')
                    ->label('نوع مدرسه')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('school_location')
                    ->label('school location')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('student_population')
                    ->label('student population')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('male_count')
                    ->label('male count')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('female_count')
                    ->label('female count')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('screening_type')
                    ->label('screening type')
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
            'index' => Pages\ListSchoolHealths::route('/'),
            'create' => Pages\CreateSchoolHealth::route('/create'),
            'edit' => Pages\EditSchoolHealth::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
