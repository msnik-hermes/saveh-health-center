<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\FamilyPlanningResource\Pages;
use App\Models\Center;
use App\Models\FamilyPlanning;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class FamilyPlanningResource extends Resource
{
    protected static ?string $model = FamilyPlanning::class;

    protected static ?string $modelLabel = 'تنظیم خانواده';

    protected static ?string $pluralModelLabel = 'تنظیم خانواده';

    protected static ?string $navigationLabel = 'تنظیم خانواده';

    protected static string|\UnitEnum|null $navigationGroup = 'سلامت خانواده';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Home;

    protected static ?int $navigationSort = 480;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('ارتباطات')
                ->schema([
                    Forms\Components\Select::make('center_id')
                        ->label('مرکز')
                        ->relationship(name: 'center', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\Center $record) => (string) (($record->name ?? null) ?: ($record->code ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\TextInput::make('created_by')
                        ->label('ایجادکننده')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('updated_by')
                        ->label('ویرایش‌کننده')
                        ->numeric()
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('اطلاعات اصلی')
                ->schema([
                    Forms\Components\TextInput::make('woman_national_code')
                        ->label('woman national code')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('woman_name')
                        ->label('woman name')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('age')
                        ->label('age')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('living_children')
                        ->label('living children')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('pregnancies_count')
                        ->label('pregnancies count')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('desired_family_size')
                        ->label('desired family size')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('current_method')
                        ->label('current method')
                        ->maxLength(255),
                    Forms\Components\Textarea::make('method_change_history')
                        ->label('method change history')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('side_effects')
                        ->label('side effects')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('method_satisfaction')
                        ->label('method satisfaction')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('counseling_sessions')
                        ->label('counseling sessions')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('referred_to')
                        ->label('referred to')
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('وضعیت و نوع')
                ->schema([
                    Forms\Components\Select::make('education_level')
                        ->label('education level')
                        ->options(['yes' => 'بله', 'no' => 'خیر', 'unknown' => 'نامشخص', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('pregnancy_status')
                        ->label('pregnancy status')
                        ->options(['active' => 'فعال', 'inactive' => 'غیرفعال', 'pending' => 'در انتظار', 'approved' => 'تأیید شده', 'rejected' => 'رد شده', 'completed' => 'تکمیل شده', 'cancelled' => 'لغو شده', 'draft' => 'پیش‌نویس', 'open' => 'باز', 'closed' => 'بسته', 'in_progress' => 'در حال انجام', 'suspended' => 'معلق', 'resolved' => 'حل‌شده', 'failed' => 'ناموفق'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('status')
                        ->label('وضعیت')
                        ->options(['active' => 'فعال', 'inactive' => 'غیرفعال', 'pending' => 'در انتظار', 'approved' => 'تأیید شده', 'rejected' => 'رد شده', 'completed' => 'تکمیل شده', 'cancelled' => 'لغو شده', 'draft' => 'پیش‌نویس', 'open' => 'باز', 'closed' => 'بسته', 'in_progress' => 'در حال انجام', 'suspended' => 'معلق', 'resolved' => 'حل‌شده', 'failed' => 'ناموفق'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('تاریخ‌ها')
                ->schema([
                    Forms\Components\DatePicker::make('method_start_date')
                        ->label('method start date')
                        ->native(false),
                    Forms\Components\DatePicker::make('last_visit_date')
                        ->label('last visit date')
                        ->native(false),
                    Forms\Components\DatePicker::make('next_visit_date')
                        ->label('ویزیت بعدی')
                        ->native(false),
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
                Tables\Columns\TextColumn::make('status')
                    ->label('وضعیت')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('center.name')
                    ->label('مرکز')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('woman_national_code')
                    ->label('woman national code')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('woman_name')
                    ->label('woman name')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('age')
                    ->label('age')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('education_level')
                    ->label('education level')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('living_children')
                    ->label('living children')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('pregnancies_count')
                    ->label('pregnancies count')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('desired_family_size')
                    ->label('desired family size')
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
                Tables\Filters\SelectFilter::make('center_id')
                    ->label('مرکز')
                    ->relationship('center', 'id')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\Center $record) => (string) ((($record->name ?? null) ?: ($record->code ?? null)) ?: ('#' . $record->getKey())))
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
            'index' => Pages\ListFamilyPlannings::route('/'),
            'create' => Pages\CreateFamilyPlanning::route('/create'),
            'edit' => Pages\EditFamilyPlanning::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
