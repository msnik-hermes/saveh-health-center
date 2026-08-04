<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\DemographicResource\Pages;
use App\Models\Center;
use App\Models\Demographic;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DemographicResource extends Resource
{
    protected static ?string $model = Demographic::class;

    protected static ?string $modelLabel = 'جمعیت';

    protected static ?string $pluralModelLabel = 'اطلاعات جمعیتی';

    protected static ?string $navigationLabel = 'اطلاعات جمعیتی';

    protected static string|\UnitEnum|null $navigationGroup = 'سلامت خانواده';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::ChartBar;

    protected static ?int $navigationSort = 470;

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
                    Forms\Components\TextInput::make('year')
                        ->label('سال')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('month')
                        ->label('ماه')
                        ->numeric()
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('اطلاعات اصلی')
                ->schema([
                    Forms\Components\TextInput::make('quarter')
                        ->label('quarter')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('male_population')
                        ->label('male population')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('female_population')
                        ->label('female population')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('urban_population')
                        ->label('urban population')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('rural_population')
                        ->label('rural population')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('age_group_data')
                        ->label('age group data')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('household_count')
                        ->label('household count')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('avg_household_size')
                        ->label('avg household size')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('births')
                        ->label('births')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('deaths')
                        ->label('deaths')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('immigration')
                        ->label('immigration')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('emigration')
                        ->label('emigration')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('education_data')
                        ->label('education data')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('source')
                        ->label('منبع')
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('مالی و مقادیر')
                ->schema([
                    Forms\Components\TextInput::make('total_population')
                        ->label('total population')
                        ->numeric()
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('وضعیت و نوع')
                ->schema([
                    Forms\Components\Textarea::make('marital_status_data')
                        ->label('marital status data')
                        ->rows(3)
                        ->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('year')
                    ->label('سال')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('quarter')
                    ->label('quarter')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('month')
                    ->label('ماه')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('total_population')
                    ->label('total population')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('male_population')
                    ->label('male population')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('female_population')
                    ->label('female population')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('urban_population')
                    ->label('urban population')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('rural_population')
                    ->label('rural population')
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
            'index' => Pages\ListDemographics::route('/'),
            'create' => Pages\CreateDemographic::route('/create'),
            'edit' => Pages\EditDemographic::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
