<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\TrainingDistributionResource\Pages;
use App\Models\Center;
use App\Models\TrainingDistribution;
use App\Models\TrainingMaterial;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TrainingDistributionResource extends Resource
{
    protected static ?string $model = TrainingDistribution::class;

    protected static ?string $modelLabel = 'توزیع آموزش';

    protected static ?string $pluralModelLabel = 'توزیع‌های آموزشی';

    protected static ?string $navigationLabel = 'توزیع آموزشی';

    protected static string|\UnitEnum|null $navigationGroup = 'آموزش';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::PaperAirplane;

    protected static ?int $navigationSort = 820;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('ارتباطات')
                ->schema([
                    Forms\Components\Select::make('material_id')
                        ->label('material')
                        ->relationship(name: 'material', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\TrainingMaterial $record) => (string) (($record->title ?? null) ?: ($record->name ?? null) ?: ('#' . $record->getKey())))
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
                    Forms\Components\DatePicker::make('distribution_date')
                        ->label('تاریخ توزیع')
                        ->native(false),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('اطلاعات اصلی')
                ->schema([
                    Forms\Components\TextInput::make('distribution_method')
                        ->label('distribution method')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('distributor')
                        ->label('distributor')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('target_group')
                        ->label('target group')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('purpose')
                        ->label('هدف')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('campaign')
                        ->label('campaign')
                        ->maxLength(255),
                    Forms\Components\Toggle::make('recipient_ack')
                        ->label('recipient ack')
                        ->default(false),
                    Forms\Components\Textarea::make('feedback')
                        ->label('بازخورد')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('photos')
                        ->label('photos')
                        ->rows(3)
                        ->columnSpanFull(),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('مالی و مقادیر')
                ->schema([
                    Forms\Components\TextInput::make('quantity')
                        ->label('تعداد')
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
                Tables\Columns\TextColumn::make('material.title')
                    ->label('material')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('distribution_date')
                    ->label('تاریخ توزیع')
                    ->searchable()
                    ->sortable()
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('distribution_method')
                    ->label('distribution method')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('distributor')
                    ->label('distributor')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('target_group')
                    ->label('target group')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('تعداد')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('purpose')
                    ->label('هدف')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('campaign')
                    ->label('campaign')
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
            'index' => Pages\ListTrainingDistributions::route('/'),
            'create' => Pages\CreateTrainingDistribution::route('/create'),
            'edit' => Pages\EditTrainingDistribution::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
