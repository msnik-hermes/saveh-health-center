<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\FormTemplateResource\Pages;
use App\Models\FormTemplate;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class FormTemplateResource extends Resource
{
    protected static ?string $model = FormTemplate::class;

    protected static ?string $modelLabel = 'قالب فرم';

    protected static ?string $pluralModelLabel = 'قالب‌های فرم';

    protected static ?string $navigationLabel = 'قالب‌های فرم';

    protected static string|\UnitEnum|null $navigationGroup = 'فرم‌ها';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::DocumentDuplicate;

    protected static ?int $navigationSort = 910;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

                public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->schema([
            Section::make('اطلاعات اصلی')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('نام')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('slug')
                        ->label('شناسه یکتا')
                        ->maxLength(255),
                ]),
            Section::make('ارتباطات')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('created_by')
                        ->label('ایجادکننده')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('updated_by')
                        ->label('ویرایش‌کننده')
                        ->numeric()
                        ->maxLength(255),
                ]),
            Section::make('وضعیت و نوع')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('category')
                        ->label('دسته')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Toggle::make('is_active')
                        ->label('فعال')
                        ->default(false),
                ]),
            Section::make('توضیحات')
                ->columns(1)
                ->schema([
                    Forms\Components\Textarea::make('description')
                        ->label('توضیحات')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),
            Section::make('سایر اطلاعات')
                ->columns(2)
                ->schema([
                    Forms\Components\Textarea::make('fields_schema')
                        ->label('fields schema')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('target_center_types')
                        ->label('target center types')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('target_roles')
                        ->label('target roles')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('version')
                        ->label('نسخه')
                        ->numeric()
                        ->maxLength(255),
                ]),
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
                Tables\Columns\IconColumn::make('is_active')
                    ->label('فعال')
                    ->boolean()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('شناسه یکتا')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('category')
                    ->label('دسته')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('توضیحات')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('fields_schema')
                    ->label('fields schema')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('target_roles')
                    ->label('target roles')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('target_center_types')
                    ->label('target center types')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('version')
                    ->label('نسخه')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('ایجاد')
                    ->jalaliDateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('فعال'),
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
            'index' => Pages\ListFormTemplates::route('/'),
            'create' => Pages\CreateFormTemplate::route('/create'),
            'edit' => Pages\EditFormTemplate::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
