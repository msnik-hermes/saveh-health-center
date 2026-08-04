<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\SystemAlertResource\Pages;
use App\Models\SystemAlert;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SystemAlertResource extends Resource
{
    protected static ?string $model = SystemAlert::class;

    protected static ?string $modelLabel = 'هشدار سیستم';

    protected static ?string $pluralModelLabel = 'هشدارهای سیستم';

    protected static ?string $navigationLabel = 'هشدارهای سیستم';

    protected static string|\UnitEnum|null $navigationGroup = 'امنیت و دسترسی';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::ExclamationCircle;

    protected static ?int $navigationSort = 1220;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('وضعیت و نوع')
                ->schema([
                    Forms\Components\Select::make('alert_type')
                        ->label('نوع هشدار')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('severity')
                        ->label('شدت')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('target_type')
                        ->label('target type')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Toggle::make('is_read')
                        ->label('خوانده شده')
                        ->default(false),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('ارتباطات')
                ->schema([
                    Forms\Components\TextInput::make('target_id')
                        ->label('target')
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('اطلاعات اصلی')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('عنوان')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('message')
                        ->label('پیام')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('resolved_by')
                        ->label('resolved by')
                        ->numeric()
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('تاریخ‌ها')
                ->schema([
                    Forms\Components\DateTimePicker::make('resolved_at')
                        ->label('حل شده در')
                        ->native(false)
                        ->seconds(false),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('توضیحات')
                ->schema([
                    Forms\Components\Textarea::make('resolution_notes')
                        ->label('resolution notes')
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
                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('alert_type')
                    ->label('نوع هشدار')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('severity')
                    ->label('شدت')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('target_type')
                    ->label('target type')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('target_id')
                    ->label('target')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('message')
                    ->label('پیام')
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_read')
                    ->label('خوانده شده')
                    ->boolean()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('resolved_by')
                    ->label('resolved by')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('resolved_at')
                    ->label('حل شده در')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('ایجاد')
                    ->dateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_read')->label('خوانده شده'),
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
            'index' => Pages\ListSystemAlerts::route('/'),
            'create' => Pages\CreateSystemAlert::route('/create'),
            'edit' => Pages\EditSystemAlert::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
