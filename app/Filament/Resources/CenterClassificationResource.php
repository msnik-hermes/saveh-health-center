<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\CenterClassificationResource\Pages;
use App\Models\Center;
use App\Models\CenterClassification;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CenterClassificationResource extends Resource
{
    protected static ?string $model = CenterClassification::class;

    protected static ?string $modelLabel = 'طبقه‌بندی مرکز';

    protected static ?string $pluralModelLabel = 'طبقه‌بندی مراکز';

    protected static ?string $navigationLabel = 'طبقه‌بندی مراکز';

    protected static string|\UnitEnum|null $navigationGroup = 'سازمان';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Tag;

    protected static ?int $navigationSort = 220;

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
                    Forms\Components\TextInput::make('updated_by')
                        ->label('ویرایش‌کننده')
                        ->numeric()
                        ->maxLength(255),
                ]),
            Section::make('وضعیت و نوع')
                ->columns(1)
                ->schema([
                    Forms\Components\Select::make('level')
                        ->label('سطح')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                ]),
            Section::make('تاریخ‌ها')
                ->columns(2)
                ->schema([
                    Forms\Components\DatePicker::make('valid_from')
                        ->label('valid from')
                        ->native(false),
                    Forms\Components\DatePicker::make('valid_to')
                        ->label('valid to')
                        ->native(false),
                ]),
            Section::make('توضیحات')
                ->columns(1)
                ->schema([
                    Forms\Components\Textarea::make('description')
                        ->label('توضیحات')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('notes')
                        ->label('یادداشت')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),
            Section::make('سایر اطلاعات')
                ->columns(1)
                ->schema([
                    Forms\Components\Select::make('classification_type')
                        ->label('classification type')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
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
                Tables\Columns\TextColumn::make('classification_type')
                    ->label('classification type')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('level')
                    ->label('سطح')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('توضیحات')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('valid_from')
                    ->label('valid from')
                    ->jalaliDate()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('valid_to')
                    ->label('valid to')
                    ->jalaliDate()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('notes')
                    ->label('یادداشت')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_by')
                    ->label('ایجادکننده')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_by')
                    ->label('ویرایش‌کننده')
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
            'index' => Pages\ListCenterClassifications::route('/'),
            'create' => Pages\CreateCenterClassification::route('/create'),
            'edit' => Pages\EditCenterClassification::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
