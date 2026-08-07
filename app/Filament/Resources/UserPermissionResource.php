<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\UserPermissionResource\Pages;
use App\Models\Permission;
use App\Models\User;
use App\Models\UserPermission;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserPermissionResource extends Resource
{
    protected static ?string $model = UserPermission::class;

    protected static ?string $modelLabel = 'مجوز کاربر';

    protected static ?string $pluralModelLabel = 'مجوزهای کاربر';

    protected static ?string $navigationLabel = 'مجوزهای کاربر';

    protected static string|\UnitEnum|null $navigationGroup = 'امنیت و دسترسی';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::FingerPrint;

    protected static ?int $navigationSort = 1140;

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
                    Forms\Components\Select::make('permission_id')
                        ->label('مجوز')
                        ->relationship(name: 'permission', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\Permission $record) => (string) (($record->display_name ?? null) ?: ($record->name ?? null) ?: ('#' . $record->getKey())))
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
                ]),
            Section::make('تاریخ‌ها')
                ->columns(1)
                ->schema([
                    Forms\Components\DateTimePicker::make('expires_at')
                        ->label('انقضا')
                        ->native(false)
                        ->seconds(false),
                ]),
            Section::make('سایر اطلاعات')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('granted_by')
                        ->label('اعطاکننده')
                        ->relationship(name: 'grantedBy', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\User $record) => (string) (($record->name ?? null) ?: ($record->email ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Toggle::make('is_granted')
                        ->label('اعطا شده')
                        ->default(false),
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
                Tables\Columns\TextColumn::make('permission.display_name')
                    ->label('مجوز')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_granted')
                    ->label('اعطا شده')
                    ->boolean()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('expires_at')
                    ->label('انقضا')
                    ->jalaliDate()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('reason')
                    ->label('دلیل')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('grantedBy.name')
                    ->label('اعطاکننده')
                    ->searchable()
                    ->sortable()
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
                Tables\Filters\SelectFilter::make('permission_id')
                    ->label('مجوز')
                    ->relationship('permission', 'id')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\Permission $record) => (string) ((($record->display_name ?? null) ?: ($record->name ?? null)) ?: ('#' . $record->getKey())))
                    ->searchable()
                    ->preload(),
                Tables\Filters\TernaryFilter::make('is_granted')->label('اعطا شده'),
                Tables\Filters\SelectFilter::make('granted_by')
                    ->label('اعطاکننده')
                    ->relationship('grantedBy', 'id')
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
            'index' => Pages\ListUserPermissions::route('/'),
            'create' => Pages\CreateUserPermission::route('/create'),
            'edit' => Pages\EditUserPermission::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
