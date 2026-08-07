<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\CenterTypeResource\Pages;
use App\Models\CenterType;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CenterTypeResource extends Resource
{
    protected static ?string $model = CenterType::class;

    protected static ?string $modelLabel = 'نوع مرکز';

    protected static ?string $pluralModelLabel = 'انواع مرکز';

    protected static ?string $navigationLabel = 'انواع مرکز';

    protected static string|\UnitEnum|null $navigationGroup = 'سازمان';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Tag;

    protected static ?int $navigationSort = 120;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

                public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->schema([
            Section::make('اطلاعات اصلی')
                ->columns(1)
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('نام')
                        ->required()
                        ->maxLength(255),
                ]),
            Section::make('وضعیت و نوع')
                ->columns(1)
                ->schema([
                    Forms\Components\Toggle::make('is_active')
                        ->label('فعال')
                        ->default(false),
                ]),
            Section::make('توضیحات')
                ->columns(1)
                ->schema([
                    Forms\Components\Textarea::make('description')
                        ->label('توضیحات')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),
            Section::make('سایر اطلاعات')
                ->columns(1)
                ->schema([
                    Forms\Components\TextInput::make('capacity')
                        ->label('ظرفیت')
                        ->numeric()
                        ->maxLength(255),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('نام')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('فعال')
                    ->boolean()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('توضیحات')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('capacity')
                    ->label('ظرفیت')
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('فعال'),
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
            'index' => Pages\ListCenterTypes::route('/'),
            'create' => Pages\CreateCenterType::route('/create'),
            'edit' => Pages\EditCenterType::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
