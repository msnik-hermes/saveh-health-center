<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\InfantChildResource\Pages;
use App\Models\Center;
use App\Models\InfantChild;
use App\Models\PregnantWoman;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class InfantChildResource extends Resource
{
    protected static ?string $model = InfantChild::class;

    protected static ?string $modelLabel = 'نوزاد/کودک';

    protected static ?string $pluralModelLabel = 'نوزادان و کودکان';

    protected static ?string $navigationLabel = 'نوزادان و کودکان';

    protected static string|\UnitEnum|null $navigationGroup = 'سلامت خانواده';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::User;

    protected static ?int $navigationSort = 430;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('ارتباطات')
                ->schema([
                    Forms\Components\Select::make('pregnant_woman_id')
                        ->label('pregnant woman')
                        ->relationship(name: 'pregnantWoman', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\PregnantWoman $record) => (string) (($record->full_name ?? null) ?: ($record->national_id ?? null) ?: ($record->name ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),
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
                    Forms\Components\TextInput::make('child_national_code')
                        ->label('child national code')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('child_name')
                        ->label('child name')
                        ->maxLength(255),
                    Forms\Components\Select::make('gender')
                        ->label('جنسیت')
                        ->options(['male' => 'مرد', 'female' => 'زن', 'other' => 'سایر', 'unknown' => 'نامشخص'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\TextInput::make('birth_weight')
                        ->label('birth weight')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('birth_length')
                        ->label('birth length')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('gestational_age')
                        ->label('سن بارداری')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('apgar_score')
                        ->label('apgar score')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('birth_complications')
                        ->label('birth complications')
                        ->maxLength(255),
                    Forms\Components\Toggle::make('breastfeeding_initiated')
                        ->label('breastfeeding initiated')
                        ->default(false),
                    Forms\Components\Textarea::make('growth_monitoring')
                        ->label('growth monitoring')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('development_milestones')
                        ->label('development milestones')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('health_problems')
                        ->label('health problems')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('referrals')
                        ->label('referrals')
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('تاریخ‌ها')
                ->schema([
                    Forms\Components\DatePicker::make('birth_date')
                        ->label('تاریخ تولد')
                        ->native(false),
                    Forms\Components\DatePicker::make('last_checkup_date')
                        ->label('last checkup date')
                        ->native(false),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('وضعیت و نوع')
                ->schema([
                    Forms\Components\Select::make('breastfeeding_type')
                        ->label('breastfeeding type')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Textarea::make('vaccination_status')
                        ->label('vaccination status')
                        ->rows(3)
                        ->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('pregnantWoman.full_name')
                    ->label('pregnant woman')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('child_national_code')
                    ->label('child national code')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('child_name')
                    ->label('child name')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('birth_date')
                    ->label('تاریخ تولد')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('gender')
                    ->label('جنسیت')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('birth_weight')
                    ->label('birth weight')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('birth_length')
                    ->label('birth length')
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
                Tables\Filters\SelectFilter::make('pregnant_woman_id')
                    ->label('pregnant woman')
                    ->relationship('pregnantWoman', 'id')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\PregnantWoman $record) => (string) ((($record->full_name ?? null) ?: ($record->national_id ?? null) ?: ($record->name ?? null)) ?: ('#' . $record->getKey())))
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
            'index' => Pages\ListInfantChildren::route('/'),
            'create' => Pages\CreateInfantChild::route('/create'),
            'edit' => Pages\EditInfantChild::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
