<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\OccupationalExaminationResource\Pages;
use App\Models\OccupationalExamination;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OccupationalExaminationResource extends Resource
{
    protected static ?string $model = OccupationalExamination::class;

    protected static ?string $modelLabel = 'معاینه شغلی';

    protected static ?string $pluralModelLabel = 'معاینات شغلی';

    protected static ?string $navigationLabel = 'معاینات شغلی';

    protected static string|\UnitEnum|null $navigationGroup = 'بازرسی و ایمنی';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Clipboard;

    protected static ?int $navigationSort = 680;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('ارتباطات')
                ->schema([
                    Forms\Components\TextInput::make('worker_id')
                        ->label('worker')
                        ->maxLength(255),
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
                    Forms\Components\TextInput::make('worker_name')
                        ->label('worker name')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('national_code')
                        ->label('کد ملی')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('company_name')
                        ->label('company name')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('job_title')
                        ->label('سمت')
                        ->maxLength(255),
                    Forms\Components\Textarea::make('hazard_exposures')
                        ->label('hazard exposures')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('physician_name')
                        ->label('physician name')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('vision_result')
                        ->label('vision result')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('hearing_result')
                        ->label('hearing result')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('spirometry_result')
                        ->label('spirometry result')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('blood_test_result')
                        ->label('blood test result')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('urine_test_result')
                        ->label('urine test result')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('blood_pressure')
                        ->label('فشار خون')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('bmi')
                        ->label('BMI')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('abnormalities')
                        ->label('abnormalities')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('restrictions')
                        ->label('محدودیت‌ها')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('referrals')
                        ->label('referrals')
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('وضعیت و نوع')
                ->schema([
                    Forms\Components\Select::make('examination_type')
                        ->label('examination type')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('fit_status')
                        ->label('fit status')
                        ->options(['active' => 'فعال', 'inactive' => 'غیرفعال', 'pending' => 'در انتظار', 'approved' => 'تأیید شده', 'rejected' => 'رد شده', 'completed' => 'تکمیل شده', 'cancelled' => 'لغو شده', 'draft' => 'پیش‌نویس', 'open' => 'باز', 'closed' => 'بسته', 'in_progress' => 'در حال انجام', 'suspended' => 'معلق', 'resolved' => 'حل‌شده', 'failed' => 'ناموفق'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('تاریخ‌ها')
                ->schema([
                    Forms\Components\DatePicker::make('examination_date')
                        ->label('examination date')
                        ->native(false),
                    Forms\Components\DatePicker::make('next_examination_date')
                        ->label('next examination date')
                        ->native(false),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('توضیحات')
                ->schema([
                    Forms\Components\Textarea::make('physical_findings')
                        ->label('physical findings')
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
                Tables\Columns\TextColumn::make('worker_id')
                    ->label('worker')
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
                Tables\Columns\TextColumn::make('company_name')
                    ->label('company name')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('job_title')
                    ->label('سمت')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('hazard_exposures')
                    ->label('hazard exposures')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('examination_type')
                    ->label('examination type')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('examination_date')
                    ->label('examination date')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('physician_name')
                    ->label('physician name')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('ایجاد')
                    ->dateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
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
            'index' => Pages\ListOccupationalExaminations::route('/'),
            'create' => Pages\CreateOccupationalExamination::route('/create'),
            'edit' => Pages\EditOccupationalExamination::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
