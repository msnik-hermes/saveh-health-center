<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CenterResource\Pages;
use App\Models\Center;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;

class CenterResource extends Resource
{
    protected static ?string $model = Center::class;
    protected static ?string $modelLabel = 'مرکز';
    protected static ?string $pluralModelLabel = 'مراکز';
    protected static ?string $navigationLabel = 'مراکز';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\TextInput::make('name')
                ->label('نام مرکز')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('code')
                ->label('کد مرکز')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(50),
            Forms\Components\Select::make('type')
                ->label('نوع')
                ->options([
                    'hospital' => 'بیمارستان',
                    'clinic' => 'کلینیک',
                    'pharmacy' => 'داروخانه',
                    'lab' => 'آزمایشگاه',
                ])
                ->required(),
            Forms\Components\TextInput::make('university')
                ->label('دانشگاه')
                ->required()
                ->maxLength(200),
            Forms\Components\TextInput::make('province')
                ->label('استان')
                ->required()
                ->maxLength(100),
            Forms\Components\TextInput::make('city')
                ->label('شهر')
                ->required()
                ->maxLength(100),
            Forms\Components\TextInput::make('phone')
                ->label('تلفن')
                ->maxLength(20),
            Forms\Components\TextInput::make('email')
                ->label('ایمیل')
                ->email()
                ->maxLength(100),
            Forms\Components\Select::make('status')
                ->label('وضعیت')
                ->options([
                    'active' => 'فعال',
                    'inactive' => 'غیرفعال',
                    'suspended' => 'معلق',
                ])
                ->default('active')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('نام مرکز')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('code')
                    ->label('کد'),
                Tables\Columns\TextColumn::make('type')
                    ->label('نوع'),
                Tables\Columns\TextColumn::make('city')
                    ->label('شهر'),
                Tables\Columns\TextColumn::make('university')
                    ->label('دانشگاه'),
                Tables\Columns\TextColumn::make('status')
                    ->label('وضعیت')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                        default => 'gray',
                    }),
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
            'index' => Pages\ListCenters::route('/'),
            'create' => Pages\CreateCenter::route('/create'),
            'edit' => Pages\EditCenter::route('/{record}/edit'),
        ];
    }
}
