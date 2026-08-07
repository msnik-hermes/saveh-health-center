<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\CenterRelationResource\Pages;
use App\Models\Center;
use App\Models\CenterRelation;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CenterRelationResource extends Resource
{
    protected static ?string $model = CenterRelation::class;

    protected static ?string $modelLabel = 'رابطه مراکز';

    protected static ?string $pluralModelLabel = 'روابط مراکز';

    protected static ?string $navigationLabel = 'روابط مراکز';

    protected static string|\UnitEnum|null $navigationGroup = 'سازمان';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Share;

    protected static ?int $navigationSort = 210;

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
                    Forms\Components\TextInput::make('created_by')
                        ->label('ایجادکننده')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('updated_by')
                        ->label('ویرایش‌کننده')
                        ->numeric()
                        ->maxLength(255),
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
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('center_id_1')
                        ->label('center 1')
                        ->relationship(name: 'center1', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\Center $record) => (string) (($record->name ?? null) ?: ($record->code ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('center_id_2')
                        ->label('center 2')
                        ->relationship(name: 'center2', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\Center $record) => (string) (($record->name ?? null) ?: ($record->code ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('relation_type')
                        ->label('نوع رابطه')
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
                Tables\Columns\TextColumn::make('center1.name')
                    ->label('center 1')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('center2.name')
                    ->label('center 2')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('relation_type')
                    ->label('نوع رابطه')
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
                Tables\Filters\SelectFilter::make('center_id_1')
                    ->label('center 1')
                    ->relationship('center1', 'id')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\Center $record) => (string) ((($record->name ?? null) ?: ($record->code ?? null)) ?: ('#' . $record->getKey())))
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('center_id_2')
                    ->label('center 2')
                    ->relationship('center2', 'id')
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
            'index' => Pages\ListCenterRelations::route('/'),
            'create' => Pages\CreateCenterRelation::route('/create'),
            'edit' => Pages\EditCenterRelation::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
