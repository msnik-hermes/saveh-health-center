<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\UnitAccessRestrictionResource\Pages;
use App\Models\OrganizationalUnit;
use App\Models\Role;
use App\Models\UnitAccessRestriction;
use App\Models\User;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UnitAccessRestrictionResource extends Resource
{
    protected static ?string $model = UnitAccessRestriction::class;

    protected static ?string $modelLabel = 'محدودیت واحد';

    protected static ?string $pluralModelLabel = 'محدودیت‌های واحد';

    protected static ?string $navigationLabel = 'محدودیت واحد';

    protected static string|\UnitEnum|null $navigationGroup = 'امنیت و دسترسی';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::NoSymbol;

    protected static ?int $navigationSort = 1170;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('ارتباطات')
                ->schema([
                    Forms\Components\Select::make('unit_id')
                        ->label('واحد')
                        ->relationship(name: 'unit', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\OrganizationalUnit $record) => (string) (($record->name ?? null) ?: ($record->code ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('role_id')
                        ->label('نقش')
                        ->relationship(name: 'role', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\Role $record) => (string) (($record->display_name ?? null) ?: ($record->name ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('user_id')
                        ->label('کاربر')
                        ->relationship(name: 'user', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\User $record) => (string) (($record->name ?? null) ?: ($record->email ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('وضعیت و نوع')
                ->schema([
                    Forms\Components\Select::make('restriction_type')
                        ->label('restriction type')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('resource_type')
                        ->label('resource type')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Textarea::make('conditions')
                        ->label('conditions')
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
                Tables\Columns\TextColumn::make('unit.name')
                    ->label('واحد')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('role.display_name')
                    ->label('نقش')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('کاربر')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('restriction_type')
                    ->label('restriction type')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('resource_type')
                    ->label('resource type')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('conditions')
                    ->label('conditions')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('ایجاد')
                    ->dateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('unit_id')
                    ->label('واحد')
                    ->relationship('unit', 'id')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\OrganizationalUnit $record) => (string) ((($record->name ?? null) ?: ($record->code ?? null)) ?: ('#' . $record->getKey())))
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('role_id')
                    ->label('نقش')
                    ->relationship('role', 'id')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\Role $record) => (string) ((($record->display_name ?? null) ?: ($record->name ?? null)) ?: ('#' . $record->getKey())))
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('کاربر')
                    ->relationship('user', 'id')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\User $record) => (string) ((($record->name ?? null) ?: ($record->email ?? null)) ?: ('#' . $record->getKey())))
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
            'index' => Pages\ListUnitAccessRestrictions::route('/'),
            'create' => Pages\CreateUnitAccessRestriction::route('/create'),
            'edit' => Pages\EditUnitAccessRestriction::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
