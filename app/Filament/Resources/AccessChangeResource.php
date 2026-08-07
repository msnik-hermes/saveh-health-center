<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\AccessChangeResource\Pages;
use App\Models\AccessChange;
use App\Models\User;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AccessChangeResource extends Resource
{
    protected static ?string $model = AccessChange::class;

    protected static ?string $modelLabel = 'تغییر دسترسی';

    protected static ?string $pluralModelLabel = 'تغییرات دسترسی';

    protected static ?string $navigationLabel = 'تغییرات دسترسی';

    protected static string|\UnitEnum|null $navigationGroup = 'امنیت و دسترسی';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::ArrowPath;

    protected static ?int $navigationSort = 1180;

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
                ->columns(1)
                ->schema([
                    Forms\Components\Select::make('user_id')
                        ->label('کاربر')
                        ->relationship(name: 'user', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\User $record) => (string) (($record->name ?? null) ?: ($record->email ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),
                ]),
            Section::make('سایر اطلاعات')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('change_type')
                        ->label('change type')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('changed_by')
                        ->label('changed by')
                        ->relationship(name: 'changedBy', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\User $record) => (string) (($record->name ?? null) ?: ($record->email ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\TextInput::make('new_value')
                        ->label('new value')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('old_value')
                        ->label('old value')
                        ->maxLength(255),
                    Forms\Components\Textarea::make('reason')
                        ->label('دلیل')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('کاربر')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('changedBy.name')
                    ->label('changed by')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('change_type')
                    ->label('change type')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('old_value')
                    ->label('old value')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('new_value')
                    ->label('new value')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('reason')
                    ->label('دلیل')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('ایجاد')
                    ->jalaliDateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('کاربر')
                    ->relationship('user', 'id')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\User $record) => (string) ((($record->name ?? null) ?: ($record->email ?? null)) ?: ('#' . $record->getKey())))
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('changed_by')
                    ->label('changed by')
                    ->relationship('changedBy', 'id')
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
            'index' => Pages\ListAccessChanges::route('/'),
            'create' => Pages\CreateAccessChange::route('/create'),
            'edit' => Pages\EditAccessChange::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
