<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\YouthHealthResource\Pages;
use App\Models\Center;
use App\Models\YouthHealth;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class YouthHealthResource extends Resource
{
    protected static ?string $model = YouthHealth::class;

    protected static ?string $modelLabel = 'سلامت جوانان';

    protected static ?string $pluralModelLabel = 'سلامت جوانان';

    protected static ?string $navigationLabel = 'سلامت جوانان';

    protected static string|\UnitEnum|null $navigationGroup = 'سلامت خانواده';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Sparkles;

    protected static ?int $navigationSort = 460;

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
                    Forms\Components\TextInput::make('national_code')
                        ->label('کد ملی')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('full_name')
                        ->label('نام کامل')
                        ->required()
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
                    Forms\Components\TextInput::make('age_group')
                        ->label('گروه سنی')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\DatePicker::make('program_attended')
                        ->label('program attended')
                        ->native(false),
                    Forms\Components\TextInput::make('topics_covered')
                        ->label('topics covered')
                        ->maxLength(255),
                    Forms\Components\Textarea::make('health_screening_results')
                        ->label('health screening results')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('mental_health_screening')
                        ->label('mental health screening')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('substance_abuse_screening')
                        ->label('substance abuse screening')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('bmi')
                        ->label('BMI')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('referrals_made')
                        ->label('referrals made')
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
                    Forms\Components\Textarea::make('risk_behaviors')
                        ->label('risk behaviors')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Select::make('follow_up_status')
                        ->label('وضعیت پیگیری')
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
                    Forms\Components\DatePicker::make('session_date')
                        ->label('session date')
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
                Tables\Columns\TextColumn::make('full_name')
                    ->label('نام کامل')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
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
                Tables\Columns\TextColumn::make('national_code')
                    ->label('کد ملی')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('age')
                    ->label('age')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('gender')
                    ->label('جنسیت')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('age_group')
                    ->label('گروه سنی')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('education_level')
                    ->label('education level')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('program_attended')
                    ->label('program attended')
                    ->date()
                    ->sortable()
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
            'index' => Pages\ListYouthHealths::route('/'),
            'create' => Pages\CreateYouthHealth::route('/create'),
            'edit' => Pages\EditYouthHealth::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
