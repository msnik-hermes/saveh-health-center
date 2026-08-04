<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\CompanyResource\Pages;
use App\Models\Company;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $modelLabel = 'شرکت';

    protected static ?string $pluralModelLabel = 'شرکت‌ها';

    protected static ?string $navigationLabel = 'شرکت‌ها';

    protected static string|\UnitEnum|null $navigationGroup = 'سازمان';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Briefcase;

    protected static ?int $navigationSort = 130;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('اطلاعات اصلی')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('نام')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('registration_number')
                        ->label('شماره ثبت')
                        ->maxLength(255),
                    Forms\Components\Toggle::make('contact_person')
                        ->label('contact person')
                        ->default(false),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('ارتباطات')
                ->schema([
                    Forms\Components\TextInput::make('national_id')
                        ->label('کد ملی')
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('اطلاعات تماس و مکان')
                ->schema([
                    Forms\Components\TextInput::make('phone')
                        ->label('تلفن')
                        ->tel()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->label('ایمیل')
                        ->email()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('address')
                        ->label('آدرس')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('city')
                        ->label('شهر')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('province')
                        ->label('استان')
                        ->maxLength(255),
                    Forms\Components\Toggle::make('contact_phone')
                        ->label('contact phone')
                        ->default(false),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('وضعیت و نوع')
                ->schema([
                    Forms\Components\Select::make('status')
                        ->label('وضعیت')
                        ->options(['active' => 'فعال', 'inactive' => 'غیرفعال', 'pending' => 'در انتظار', 'approved' => 'تأیید شده', 'rejected' => 'رد شده', 'completed' => 'تکمیل شده', 'cancelled' => 'لغو شده', 'draft' => 'پیش‌نویس', 'open' => 'باز', 'closed' => 'بسته', 'in_progress' => 'در حال انجام', 'suspended' => 'معلق', 'resolved' => 'حل‌شده', 'failed' => 'ناموفق'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('توضیحات')
                ->schema([
                    Forms\Components\Textarea::make('notes')
                        ->label('یادداشت')
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
                Tables\Columns\TextColumn::make('name')
                    ->label('نام')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('وضعیت')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('تلفن')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('city')
                    ->label('شهر')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('ایمیل')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('registration_number')
                    ->label('شماره ثبت')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('national_id')
                    ->label('کد ملی')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('address')
                    ->label('آدرس')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('province')
                    ->label('استان')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('ایجاد')
                    ->dateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('وضعیت')
                    ->options(['active' => 'فعال', 'inactive' => 'غیرفعال', 'pending' => 'در انتظار', 'approved' => 'تأیید شده', 'rejected' => 'رد شده', 'completed' => 'تکمیل شده', 'cancelled' => 'لغو شده', 'draft' => 'پیش‌نویس', 'open' => 'باز', 'closed' => 'بسته', 'in_progress' => 'در حال انجام', 'suspended' => 'معلق', 'resolved' => 'حل‌شده', 'failed' => 'ناموفق']),
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
