<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\AccessReportResource\Pages;
use App\Models\AccessReport;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AccessReportResource extends Resource
{
    protected static ?string $model = AccessReport::class;

    protected static ?string $modelLabel = 'گزارش دسترسی';

    protected static ?string $pluralModelLabel = 'گزارش‌های دسترسی';

    protected static ?string $navigationLabel = 'گزارش دسترسی';

    protected static string|\UnitEnum|null $navigationGroup = 'امنیت و دسترسی';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::DocumentChartBar;

    protected static ?int $navigationSort = 1190;

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
                    Forms\Components\TextInput::make('user_id')
                        ->label('کاربر')
                        ->maxLength(255),
                ]),
            Section::make('سایر اطلاعات')
                ->columns(2)
                ->schema([
                    Forms\Components\Textarea::make('filters')
                        ->label('filters')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Select::make('report_type')
                        ->label('report type')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Textarea::make('results')
                        ->label('results')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->label('کاربر')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('report_type')
                    ->label('report type')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('filters')
                    ->label('filters')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('results')
                    ->label('results')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('ایجاد')
                    ->jalaliDateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
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
            'index' => Pages\ListAccessReports::route('/'),
            'create' => Pages\CreateAccessReport::route('/create'),
            'edit' => Pages\EditAccessReport::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
