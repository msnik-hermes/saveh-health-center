<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\DentalServiceResource\Pages;
use App\Models\Center;
use App\Models\DentalService;
use App\Models\Employee;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DentalServiceResource extends Resource
{
    protected static ?string $model = DentalService::class;

    protected static ?string $modelLabel = 'خدمت دندان';

    protected static ?string $pluralModelLabel = 'خدمات دندانپزشکی';

    protected static ?string $navigationLabel = 'خدمات دندانپزشکی';

    protected static string|\UnitEnum|null $navigationGroup = 'سلامت و درمان';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::FaceSmile;

    protected static ?int $navigationSort = 550;

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
                    Forms\Components\Select::make('dentist_id')
                        ->label('dentist')
                        ->relationship(name: 'dentist', titleAttribute: 'id')
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
            Section::make('اطلاعات اصلی')
                ->schema([
                    Forms\Components\TextInput::make('patient_national_code')
                        ->label('patient national code')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('patient_name')
                        ->label('patient name')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('patient_age')
                        ->label('سن بیمار')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\Select::make('patient_gender')
                        ->label('جنسیت بیمار')
                        ->options(['male' => 'مرد', 'female' => 'زن', 'other' => 'سایر', 'unknown' => 'نامشخص'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\TextInput::make('teeth_involved')
                        ->label('teeth involved')
                        ->maxLength(255),
                    Forms\Components\Textarea::make('materials_used')
                        ->label('materials used')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('fee')
                        ->label('fee')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\Toggle::make('follow_up_needed')
                        ->label('follow up needed')
                        ->default(false),
                    Forms\Components\TextInput::make('patient_satisfaction')
                        ->label('patient satisfaction')
                        ->numeric()
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('تاریخ‌ها')
                ->schema([
                    Forms\Components\DatePicker::make('visit_date')
                        ->label('تاریخ ویزیت')
                        ->native(false),
                    Forms\Components\DatePicker::make('follow_up_date')
                        ->label('follow up date')
                        ->native(false),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('وضعیت و نوع')
                ->schema([
                    Forms\Components\Select::make('service_type')
                        ->label('نوع خدمت')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Textarea::make('diagnosis_code')
                        ->label('diagnosis code')
                        ->rows(3)
                        ->columnSpanFull(),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('توضیحات')
                ->schema([
                    Forms\Components\Toggle::make('treatment_provided')
                        ->label('treatment provided')
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
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('patient_age')
                    ->label('سن بیمار')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('patient_gender')
                    ->label('جنسیت بیمار')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('visit_date')
                    ->label('تاریخ ویزیت')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('dentist.first_name')
                    ->label('dentist')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('service_type')
                    ->label('نوع خدمت')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('teeth_involved')
                    ->label('teeth involved')
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
                Tables\Filters\SelectFilter::make('dentist_id')
                    ->label('dentist')
                    ->relationship('dentist', 'id')
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
            'index' => Pages\ListDentalServices::route('/'),
            'create' => Pages\CreateDentalService::route('/create'),
            'edit' => Pages\EditDentalService::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
