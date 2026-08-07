<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\EarlyRetirementCaseResource\Pages;
use App\Models\EarlyRetirementCase;
use App\Models\Employee;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EarlyRetirementCaseResource extends Resource
{
    protected static ?string $model = EarlyRetirementCase::class;

    protected static ?string $modelLabel = 'بازنشستگی پیش از موعد';

    protected static ?string $pluralModelLabel = 'موارد بازنشستگی';

    protected static ?string $navigationLabel = 'بازنشستگی پیش از موعد';

    protected static string|\UnitEnum|null $navigationGroup = 'منابع انسانی';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Flag;

    protected static ?int $navigationSort = 270;

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
                ->columns(1)
                ->schema([
                    Forms\Components\TextInput::make('national_code')
                        ->label('کد ملی')
                        ->maxLength(255),
                ]),
            Section::make('ارتباطات')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('created_by')
                        ->label('ایجادکننده')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\Select::make('employee_id')
                        ->label('کارمند')
                        ->relationship(name: 'employee', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\Employee $record) => (string) (($record->first_name ?? null) ?: ($record->last_name ?? null) ?: ($record->personnel_code ?? null) ?: ($record->name ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\TextInput::make('updated_by')
                        ->label('ویرایش‌کننده')
                        ->numeric()
                        ->maxLength(255),
                ]),
            Section::make('تاریخ‌ها')
                ->columns(2)
                ->schema([
                    Forms\Components\DatePicker::make('birth_date')
                        ->label('تاریخ تولد')
                        ->native(false),
                    Forms\Components\DatePicker::make('application_date')
                        ->label('application date')
                        ->native(false),
                    Forms\Components\DatePicker::make('expected_retirement_date')
                        ->label('expected retirement date')
                        ->native(false),
                    Forms\Components\DatePicker::make('resolution_date')
                        ->label('resolution date')
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
            Section::make('سایر اطلاعات')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('case_status')
                        ->label('case status')
                        ->options(['active' => 'فعال', 'inactive' => 'غیرفعال', 'pending' => 'در انتظار', 'approved' => 'تأیید شده', 'rejected' => 'رد شده', 'completed' => 'تکمیل شده', 'cancelled' => 'لغو شده', 'draft' => 'پیش‌نویس', 'open' => 'باز', 'closed' => 'بسته', 'in_progress' => 'در حال انجام', 'suspended' => 'معلق', 'resolved' => 'حل‌شده', 'failed' => 'ناموفق'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\TextInput::make('company_name')
                        ->label('company name')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('current_age')
                        ->label('current age')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('dependent_count')
                        ->label('dependent count')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\Select::make('education_level')
                        ->label('education level')
                        ->options(['yes' => 'بله', 'no' => 'خیر', 'unknown' => 'نامشخص', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\TextInput::make('eligibility')
                        ->label('eligibility')
                        ->maxLength(255),
                    Forms\Components\Select::make('family_status')
                        ->label('family status')
                        ->options(['active' => 'فعال', 'inactive' => 'غیرفعال', 'pending' => 'در انتظار', 'approved' => 'تأیید شده', 'rejected' => 'رد شده', 'completed' => 'تکمیل شده', 'cancelled' => 'لغو شده', 'draft' => 'پیش‌نویس', 'open' => 'باز', 'closed' => 'بسته', 'in_progress' => 'در حال انجام', 'suspended' => 'معلق', 'resolved' => 'حل‌شده', 'failed' => 'ناموفق'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\TextInput::make('hazardous_service_years')
                        ->label('hazardous service years')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('impairment_rating')
                        ->label('impairment rating')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('job_title')
                        ->label('سمت')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('medical_assessment')
                        ->label('medical assessment')
                        ->maxLength(255),
                    Forms\Components\Textarea::make('occupational_conditions')
                        ->label('occupational conditions')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('recommendation')
                        ->label('recommendation')
                        ->maxLength(255),
                    Forms\Components\Select::make('social_security_status')
                        ->label('social security status')
                        ->options(['active' => 'فعال', 'inactive' => 'غیرفعال', 'pending' => 'در انتظار', 'approved' => 'تأیید شده', 'rejected' => 'رد شده', 'completed' => 'تکمیل شده', 'cancelled' => 'لغو شده', 'draft' => 'پیش‌نویس', 'open' => 'باز', 'closed' => 'بسته', 'in_progress' => 'در حال انجام', 'suspended' => 'معلق', 'resolved' => 'حل‌شده', 'failed' => 'ناموفق'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\TextInput::make('total_service_years')
                        ->label('total service years')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('work_history')
                        ->label('work history')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('worker_name')
                        ->label('worker name')
                        ->maxLength(255),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.first_name')
                    ->label('کارمند')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('worker_name')
                    ->label('worker name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('national_code')
                    ->label('کد ملی')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('birth_date')
                    ->label('تاریخ تولد')
                    ->jalaliDate()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('current_age')
                    ->label('current age')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('company_name')
                    ->label('company name')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('job_title')
                    ->label('سمت')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('total_service_years')
                    ->label('total service years')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('hazardous_service_years')
                    ->label('hazardous service years')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('ایجاد')
                    ->jalaliDateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('employee_id')
                    ->label('کارمند')
                    ->relationship('employee', 'id')
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
            'index' => Pages\ListEarlyRetirementCases::route('/'),
            'create' => Pages\CreateEarlyRetirementCase::route('/create'),
            'edit' => Pages\EditEarlyRetirementCase::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
