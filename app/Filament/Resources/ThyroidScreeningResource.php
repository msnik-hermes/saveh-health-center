<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\ThyroidScreeningResource\Pages;
use App\Models\Center;
use App\Models\ThyroidScreening;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ThyroidScreeningResource extends Resource
{
    protected static ?string $model = ThyroidScreening::class;

    protected static ?string $modelLabel = 'غربالگری تیروئید';

    protected static ?string $pluralModelLabel = 'غربالگری تیروئید';

    protected static ?string $navigationLabel = 'غربالگری تیروئید';

    protected static string|\UnitEnum|null $navigationGroup = 'سلامت و درمان';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Beaker;

    protected static ?int $navigationSort = 540;

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
                    Forms\Components\TextInput::make('patient_national_code')
                        ->label('patient national code')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('age')
                        ->label('age')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\Select::make('gender')
                        ->label('جنسیت')
                        ->options(['male' => 'مرد', 'female' => 'زن', 'other' => 'سایر', 'unknown' => 'نامشخص'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\TextInput::make('target_group')
                        ->label('target group')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('goiter_grade')
                        ->label('goiter grade')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('urine_iodine')
                        ->label('urine iodine')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('free_t4')
                        ->label('free t4')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('thyroid_antibodies')
                        ->label('thyroid antibodies')
                        ->maxLength(255),
                    Forms\Components\Textarea::make('diagnosis')
                        ->label('تشخیص')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('salt_iodine_test')
                        ->label('salt iodine test')
                        ->numeric()
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('وضعیت و نوع')
                ->schema([
                    Forms\Components\Select::make('screening_type')
                        ->label('screening type')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('tsh_level')
                        ->label('tsh level')
                        ->options(['yes' => 'بله', 'no' => 'خیر', 'unknown' => 'نامشخص', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('توضیحات')
                ->schema([
                    Forms\Components\Toggle::make('treatment_recommendation')
                        ->label('treatment recommendation')
                        ->default(false),
                    Forms\Components\Textarea::make('notes')
                        ->label('یادداشت')
                        ->rows(3)
                        ->columnSpanFull(),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('تاریخ‌ها')
                ->schema([
                    Forms\Components\DatePicker::make('screening_date')
                        ->label('تاریخ غربالگری')
                        ->native(false),
                    Forms\Components\DatePicker::make('follow_up_date')
                        ->label('follow up date')
                        ->native(false),
                ])
                ->columns(2)
                ->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('center.name')
                    ->label('مرکز')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('patient_national_code')
                    ->label('patient national code')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('age')
                    ->label('age')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('gender')
                    ->label('جنسیت')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('screening_type')
                    ->label('screening type')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('target_group')
                    ->label('target group')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('goiter_grade')
                    ->label('goiter grade')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('urine_iodine')
                    ->label('urine iodine')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('tsh_level')
                    ->label('tsh level')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('ایجاد')
                    ->dateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
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
            'index' => Pages\ListThyroidScreenings::route('/'),
            'create' => Pages\CreateThyroidScreening::route('/create'),
            'edit' => Pages\EditThyroidScreening::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
