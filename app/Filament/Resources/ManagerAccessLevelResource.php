<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\ManagerAccessLevelResource\Pages;
use App\Models\ManagerAccessLevel;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ManagerAccessLevelResource extends Resource
{
    protected static ?string $model = ManagerAccessLevel::class;

    protected static ?string $modelLabel = 'دسترسی مدیر';

    protected static ?string $pluralModelLabel = 'دسترسی مدیران';

    protected static ?string $navigationLabel = 'دسترسی مدیران';

    protected static string|\UnitEnum|null $navigationGroup = 'امنیت و دسترسی';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Key;

    protected static ?int $navigationSort = 1160;

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
                    Forms\Components\TextInput::make('access_level_id')
                        ->label('access level')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('role_id')
                        ->label('نقش')
                        ->maxLength(255),
                ]),
            Section::make('سایر اطلاعات')
                ->columns(2)
                ->schema([
                    Forms\Components\Toggle::make('can_approve')
                        ->label('can approve')
                        ->default(false),
                    Forms\Components\Toggle::make('can_escalate')
                        ->label('can escalate')
                        ->default(false),
                    Forms\Components\Toggle::make('can_override')
                        ->label('can override')
                        ->default(false),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('role_id')
                    ->label('نقش')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('access_level_id')
                    ->label('access level')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('can_approve')
                    ->label('can approve')
                    ->boolean()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('can_escalate')
                    ->label('can escalate')
                    ->boolean()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('can_override')
                    ->label('can override')
                    ->boolean()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('ایجاد')
                    ->jalaliDateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('can_approve')->label('can approve'),
                Tables\Filters\TernaryFilter::make('can_escalate')->label('can escalate'),
                Tables\Filters\TernaryFilter::make('can_override')->label('can override'),
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
            'index' => Pages\ListManagerAccessLevels::route('/'),
            'create' => Pages\CreateManagerAccessLevel::route('/create'),
            'edit' => Pages\EditManagerAccessLevel::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
