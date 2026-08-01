<?php

namespace App\Filament\Resources;

use App\Models\CenterType;
use Filament\Forms;
use Filament\Forms\Components\Integer as IntegerComponent;
use Filament\Forms\Components\TextInput as TextInputComponent;
use Filament\Forms\Components\Toggle as ToggleComponent;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;

class CenterTypeResource extends Resource
{
    protected static ?string $model = CenterType::class;
    protected static ?string $modelLabel = 'نوع مرکز';
    protected static ?string $pluralModelLabel = 'انواع مرکز';
    protected static ?string $navigationLabel = 'انواع مرکز';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\TextInput::make('name')
                ->label('نام نوع')
                ->required()
                ->maxLength(100),
            Forms\Components\TextInput::make('description')
                ->label('توضیحات')
                ->maxLength(500),
            Forms\Components\Integer::make('capacity')
                ->label('ظرفیت')
                ->min(0)
                ->nullable(),
            Forms\Components\Toggle::make('is_active')
                ->label('فعال')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('نام')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('توضیحات')
                    ->limit(100),
                Tables\Columns\IntegerColumn::make('capacity')
                    ->label('ظرفیت'),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('فعال'),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCenterTypes::route('/'),
            'create' => Pages\CreateCenterType::route('/create'),
            'edit' => Pages\EditCenterType::route('/{record}/edit'),
        ];
    }
}
