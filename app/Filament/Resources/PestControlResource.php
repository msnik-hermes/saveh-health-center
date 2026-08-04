<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\PestControlResource\Pages;
use App\Models\Center;
use App\Models\PestControl;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PestControlResource extends Resource
{
    protected static ?string $model = PestControl::class;

    protected static ?string $modelLabel = 'مبارزه با آفات';

    protected static ?string $pluralModelLabel = 'مبارزه با آفات';

    protected static ?string $navigationLabel = 'مبارزه با آفات';

    protected static string|\UnitEnum|null $navigationGroup = 'بازرسی و ایمنی';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::BugAnt;

    protected static ?int $navigationSort = 670;

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
            Section::make('تاریخ‌ها')
                ->schema([
                    Forms\Components\DatePicker::make('survey_date')
                        ->label('survey date')
                        ->native(false),
                    Forms\Components\TextInput::make('gps_lat')
                        ->label('عرض جغرافیایی')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\DatePicker::make('follow_up_date')
                        ->label('follow up date')
                        ->native(false),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('اطلاعات تماس و مکان')
                ->schema([
                    Forms\Components\TextInput::make('location')
                        ->label('مکان')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('gps_lng')
                        ->label('طول جغرافیایی')
                        ->numeric()
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('وضعیت و نوع')
                ->schema([
                    Forms\Components\Select::make('area_type')
                        ->label('area type')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('pest_type')
                        ->label('نوع آفت')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('trap_type')
                        ->label('trap type')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\TextInput::make('environmental_conditions')
                        ->label('environmental conditions')
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('اطلاعات اصلی')
                ->schema([
                    Forms\Components\TextInput::make('traps_deployed')
                        ->label('traps deployed')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('traps_checked')
                        ->label('traps checked')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('species_identified')
                        ->label('speciesentified')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('disease_testing')
                        ->label('disease testing')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('previous_control')
                        ->label('previous control')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('recommended_actions')
                        ->label('recommended actions')
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('مالی و مقادیر')
                ->schema([
                    Forms\Components\TextInput::make('total_catches')
                        ->label('total catches')
                        ->numeric()
                        ->maxLength(255),
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
                Tables\Columns\TextColumn::make('survey_date')
                    ->label('survey date')
                    ->searchable()
                    ->sortable()
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('location')
                    ->label('مکان')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('gps_lat')
                    ->label('عرض جغرافیایی')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('gps_lng')
                    ->label('طول جغرافیایی')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('area_type')
                    ->label('area type')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('pest_type')
                    ->label('نوع آفت')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('trap_type')
                    ->label('trap type')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('traps_deployed')
                    ->label('traps deployed')
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
            'index' => Pages\ListPestControls::route('/'),
            'create' => Pages\CreatePestControl::route('/create'),
            'edit' => Pages\EditPestControl::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
