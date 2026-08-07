<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\TrainingServiceRecordResource\Pages;
use App\Models\Center;
use App\Models\TrainingMaterial;
use App\Models\TrainingServiceRecord;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TrainingServiceRecordResource extends Resource
{
    protected static ?string $model = TrainingServiceRecord::class;

    protected static ?string $modelLabel = 'خدمت آموزشی';

    protected static ?string $pluralModelLabel = 'سوابق خدمات آموزشی';

    protected static ?string $navigationLabel = 'سوابق آموزش';

    protected static string|\UnitEnum|null $navigationGroup = 'آموزش';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::ClipboardDocument;

    protected static ?int $navigationSort = 830;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

                public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->schema([
            Section::make('ارتباطات')
                ->columns(2)
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
                    Forms\Components\Select::make('material_id')
                        ->label('material')
                        ->relationship(name: 'material', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\TrainingMaterial $record) => (string) (($record->title ?? null) ?: ($record->name ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\TextInput::make('updated_by')
                        ->label('ویرایش‌کننده')
                        ->numeric()
                        ->maxLength(255),
                ]),
            Section::make('مکان و تماس')
                ->columns(1)
                ->schema([
                    Forms\Components\TextInput::make('location')
                        ->label('مکان')
                        ->maxLength(255),
                ]),
            Section::make('تاریخ‌ها')
                ->columns(1)
                ->schema([
                    Forms\Components\DatePicker::make('session_date')
                        ->label('session date')
                        ->native(false),
                ]),
            Section::make('مالی و مقادیر')
                ->columns(1)
                ->schema([
                    Forms\Components\TextInput::make('cost')
                        ->label('هزینه')
                        ->numeric()
                        ->maxLength(255),
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
                    Forms\Components\Textarea::make('attendance_list')
                        ->label('attendance list')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('duration_hours')
                        ->label('duration hours')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('evaluation_score')
                        ->label('evaluation score')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('participants_count')
                        ->label('participants count')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('photos')
                        ->label('photos')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Select::make('session_type')
                        ->label('session type')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\TextInput::make('topic')
                        ->label('topic')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('trainer')
                        ->label('trainer')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('unique_reached')
                        ->label('unique reached')
                        ->numeric()
                        ->maxLength(255),
                ]),
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
                Tables\Columns\TextColumn::make('material.title')
                    ->label('material')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('session_date')
                    ->label('session date')
                    ->searchable()
                    ->sortable()
                    ->jalaliDate()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('session_type')
                    ->label('session type')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('topic')
                    ->label('topic')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('trainer')
                    ->label('trainer')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('duration_hours')
                    ->label('duration hours')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('participants_count')
                    ->label('participants count')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('unique_reached')
                    ->label('unique reached')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('ایجاد')
                    ->jalaliDateTime()
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
                Tables\Filters\SelectFilter::make('material_id')
                    ->label('material')
                    ->relationship('material', 'id')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\TrainingMaterial $record) => (string) ((($record->title ?? null) ?: ($record->name ?? null)) ?: ('#' . $record->getKey())))
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
            'index' => Pages\ListTrainingServiceRecords::route('/'),
            'create' => Pages\CreateTrainingServiceRecord::route('/create'),
            'edit' => Pages\EditTrainingServiceRecord::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
