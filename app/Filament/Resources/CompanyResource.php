<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationGroup = 'مدیریت سازمانی';

    protected static ?string $navigationLabel = 'شرکت‌ها';

    protected static ?string $modelLabel = 'شرکت';

    protected static ?string $pluralModelLabel = 'شرکت‌ها';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('اطلاعات شرکت')
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
                                'faal' => 'فعال',
                                'ghair_faal' => 'غیرفعال',
                                'tahrim' => 'تحریم',
                            ])
                            ->default('faal')
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('اطلاعات تماس')
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->label('تلفن')
                            ->maxLength(20),
                        Forms\Components\TextInput::make('email')
                            ->label('ایمیل')
                            ->email()
                            ->maxLength(100),
                        Forms\Components\TextInput::make('contact_person')
                            ->label('شخص تماس')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('contact_phone')
                            ->label('تلفن تماس')
                            ->maxLength(20),
                    ])->columns(2),

                Forms\Components\Section::make('آدرس')
                    ->schema([
                        Forms\Components\Textarea::make('address')
                            ->label('آدرس')
                            ->rows(3),
                        Forms\Components\TextInput::make('city')
                            ->label('شهر')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('province')
                            ->label('استان')
                            ->maxLength(100),
                    ])->columns(3),

                Forms\Components\Section::make('توضیحات')
                    ->schema([
                        Forms\Components\Textarea::make('notes')
                            ->label('یادداشت‌ها')
                            ->rows(3),
                    ]),
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
                Tables\Columns\TextColumn::make('national_id')
                    ->label('شماره ملی')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('تلفن'),
                Tables\Columns\TextColumn::make('city')
                    ->label('شهر'),
                Tables\Columns\TextColumn::make('status')
                    ->label('وضعیت')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'faal' => 'success',
                        'ghair_faal' => 'danger',
                        'tahrim' => 'warning',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'faal' => 'فعال',
                        'ghair_faal' => 'غیرفعال',
                        'tahrim' => 'تحریم',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
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
