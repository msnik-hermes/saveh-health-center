<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Models\Company;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;
    protected static ?string $modelLabel = 'شرکت';
    protected static ?string $pluralModelLabel = 'شرکت‌ها';
    protected static ?string $navigationLabel = 'شرکت‌ها';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('نام شرکت')
                    ->required()
                    ->maxLength(200),
                Forms\Components\TextInput::make('registration_number')
                    ->label('شماره ثبت')
                    ->maxLength(100),
                Forms\Components\TextInput::make('national_id')
                    ->label('شماره ملی')
                    ->maxLength(20),
                Forms\Components\Select::make('status')
                    ->label('وضعیت')
                    ->options([
                        'active' => 'فعال',
                        'inactive' => 'غیرفعال',
                    ])
                    ->default('active')
                    ->required(),
                Forms\Components\TextInput::make('phone')
                    ->label('تلفن')
                    ->maxLength(20),
                Forms\Components\TextInput::make('email')
                    ->label('ایمیل')
                    ->email()
                    ->maxLength(100),
                Forms\Components\TextInput::make('city')
                    ->label('شهر')
                    ->maxLength(100),
                Forms\Components\TextInput::make('province')
                    ->label('استان')
                    ->maxLength(100),
                Forms\Components\Textarea::make('address')
                    ->label('آدرس')
                    ->rows(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('نام شرکت')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('registration_number')
                    ->label('شماره ثبت'),
                Tables\Columns\TextColumn::make('phone')
                    ->label('تلفن'),
                Tables\Columns\TextColumn::make('city')
                    ->label('شهر'),
                Tables\Columns\TextColumn::make('status')
                    ->label('وضعیت')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => 'فعال',
                        'inactive' => 'غیرفعال',
                        default => $state,
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
