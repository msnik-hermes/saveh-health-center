<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\MaternalHealthResource\Pages;
use App\Models\Center;
use App\Models\MaternalHealth;
use App\Models\PregnantWoman;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MaternalHealthResource extends Resource
{
    protected static ?string $model = MaternalHealth::class;

    protected static ?string $modelLabel = 'سلامت مادر';

    protected static ?string $pluralModelLabel = 'سلامت مادران';

    protected static ?string $navigationLabel = 'سلامت مادران';

    protected static string|\UnitEnum|null $navigationGroup = 'سلامت خانواده';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Heart;

    protected static ?int $navigationSort = 420;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('ارتباطات')
                ->schema([
                    Forms\Components\Select::make('pregnant_woman_id')
                        ->label('pregnant woman')
                        ->relationship(name: 'pregnantWoman', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\PregnantWoman $record) => (string) (($record->full_name ?? null) ?: ($record->national_id ?? null) ?: ($record->name ?? null) ?: ('#' . $record->getKey())))
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
                    Forms\Components\DatePicker::make('visit_date')
                        ->label('تاریخ ویزیت')
                        ->native(false),
                    Forms\Components\Toggle::make('fetal_heartbeat')
                        ->label('fetal heartbeat')
                        ->default(false),
                    Forms\Components\DatePicker::make('next_visit_date')
                        ->label('ویزیت بعدی')
                        ->native(false),
                    Forms\Components\DatePicker::make('delivery_date')
                        ->label('delivery date')
                        ->native(false),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('وضعیت و نوع')
                ->schema([
                    Forms\Components\Select::make('visit_type')
                        ->label('visit type')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('delivery_type')
                        ->label('delivery type')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('اطلاعات اصلی')
                ->schema([
                    Forms\Components\TextInput::make('gestational_week')
                        ->label('gestational week')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('weight')
                        ->label('وزن')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('blood_pressure')
                        ->label('فشار خون')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('urine_protein')
                        ->label('urine protein')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('urine_sugar')
                        ->label('urine sugar')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('fundal_height')
                        ->label('fundal height')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('hemoglobin')
                        ->label('hemoglobin')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\Toggle::make('ultrasound_performed')
                        ->label('ultrasound performed')
                        ->default(false),
                    Forms\Components\TextInput::make('complications')
                        ->label('complications')
                        ->maxLength(255),
                    Forms\Components\Textarea::make('screening_results')
                        ->label('screening results')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('tetanus_dose')
                        ->label('tetanus dose')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('postnatal_visits')
                        ->label('postnatal visits')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('pnc_complications')
                        ->label('pnc complications')
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('اطلاعات تماس و مکان')
                ->schema([
                    Forms\Components\TextInput::make('delivery_location')
                        ->label('delivery location')
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
                Tables\Columns\TextColumn::make('pregnantWoman.full_name')
                    ->label('pregnant woman')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('visit_date')
                    ->label('تاریخ ویزیت')
                    ->searchable()
                    ->sortable()
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('visit_type')
                    ->label('visit type')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('gestational_week')
                    ->label('gestational week')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('weight')
                    ->label('وزن')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('blood_pressure')
                    ->label('فشار خون')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('urine_protein')
                    ->label('urine protein')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('urine_sugar')
                    ->label('urine sugar')
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
                Tables\Filters\SelectFilter::make('pregnant_woman_id')
                    ->label('pregnant woman')
                    ->relationship('pregnantWoman', 'id')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\PregnantWoman $record) => (string) ((($record->full_name ?? null) ?: ($record->national_id ?? null) ?: ($record->name ?? null)) ?: ('#' . $record->getKey())))
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
            'index' => Pages\ListMaternalHealths::route('/'),
            'create' => Pages\CreateMaternalHealth::route('/create'),
            'edit' => Pages\EditMaternalHealth::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
