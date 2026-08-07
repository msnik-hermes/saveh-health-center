<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\TrainingMaterialResource\Pages;
use App\Models\TrainingMaterial;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TrainingMaterialResource extends Resource
{
    protected static ?string $model = TrainingMaterial::class;

    protected static ?string $modelLabel = 'محتوای آموزشی';

    protected static ?string $pluralModelLabel = 'محتوای آموزشی';

    protected static ?string $navigationLabel = 'محتوای آموزشی';

    protected static string|\UnitEnum|null $navigationGroup = 'آموزش';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::BookOpen;

    protected static ?int $navigationSort = 810;

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
                ->columns(1)
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('عنوان')
                        ->required()
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
                    Forms\Components\Select::make('type')
                        ->label('نوع')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                ]),
            Section::make('تاریخ‌ها')
                ->columns(1)
                ->schema([
                    Forms\Components\DatePicker::make('production_date')
                        ->label('production date')
                        ->native(false),
                ]),
            Section::make('مالی و مقادیر')
                ->columns(1)
                ->schema([
                    Forms\Components\TextInput::make('cost')
                        ->label('هزینه')
                        ->numeric()
                        ->maxLength(255),
                ]),
            Section::make('توضیحات')
                ->columns(1)
                ->schema([
                    Forms\Components\Textarea::make('notes')
                        ->label('یادداشت')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),
            Section::make('سایر اطلاعات')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('approval_status')
                        ->label('approval status')
                        ->options(['active' => 'فعال', 'inactive' => 'غیرفعال', 'pending' => 'در انتظار', 'approved' => 'تأیید شده', 'rejected' => 'رد شده', 'completed' => 'تکمیل شده', 'cancelled' => 'لغو شده', 'draft' => 'پیش‌نویس', 'open' => 'باز', 'closed' => 'بسته', 'in_progress' => 'در حال انجام', 'suspended' => 'معلق', 'resolved' => 'حل‌شده', 'failed' => 'ناموفق'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\TextInput::make('current_stock')
                        ->label('current stock')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('designer')
                        ->label('designer')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('digital_format')
                        ->label('digital format')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('file_location')
                        ->label('file location')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('language')
                        ->label('زبان')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('minimum_stock')
                        ->label('minimum stock')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('print_quantity')
                        ->label('print quantity')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('reviewer')
                        ->label('reviewer')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('target_audience')
                        ->label('target audience')
                        ->maxLength(255),
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
                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('نوع')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('category')
                    ->label('دسته')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('target_audience')
                    ->label('target audience')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('language')
                    ->label('زبان')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('production_date')
                    ->label('production date')
                    ->jalaliDate()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('designer')
                    ->label('designer')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('reviewer')
                    ->label('reviewer')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('approval_status')
                    ->label('approval status')
                    ->badge()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('ایجاد')
                    ->jalaliDateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('approval_status')
                    ->label('approval status')
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
            'index' => Pages\ListTrainingMaterials::route('/'),
            'create' => Pages\CreateTrainingMaterial::route('/create'),
            'edit' => Pages\EditTrainingMaterial::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
