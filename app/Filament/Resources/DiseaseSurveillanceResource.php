<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\DiseaseSurveillanceResource\Pages;
use App\Models\Center;
use App\Models\DiseaseSurveillance;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DiseaseSurveillanceResource extends Resource
{
    protected static ?string $model = DiseaseSurveillance::class;

    protected static ?string $modelLabel = 'نظارت بیماری';

    protected static ?string $pluralModelLabel = 'نظارت بیماری‌ها';

    protected static ?string $navigationLabel = 'نظارت بیماری‌ها';

    protected static string|\UnitEnum|null $navigationGroup = 'سلامت و درمان';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Beaker;

    protected static ?int $navigationSort = 510;

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
                        ->required(),
                    Forms\Components\TextInput::make('case_id')
                        ->label('شناسه پرونده')
                        ->maxLength(255),
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
            Section::make('وضعیت و نوع')
                ->schema([
                    Forms\Components\Select::make('disease_category')
                        ->label('دسته بیماری')
                        ->options(['yes' => 'بله', 'no' => 'خیر', 'unknown' => 'نامشخص', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('severity')
                        ->label('شدت')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('outcome')
                        ->label('پیامد')
                        ->options(['active' => 'فعال', 'inactive' => 'غیرفعال', 'pending' => 'در انتظار', 'approved' => 'تأیید شده', 'rejected' => 'رد شده', 'completed' => 'تکمیل شده', 'cancelled' => 'لغو شده', 'draft' => 'پیش‌نویس', 'open' => 'باز', 'closed' => 'بسته', 'in_progress' => 'در حال انجام', 'suspended' => 'معلق', 'resolved' => 'حل‌شده', 'failed' => 'ناموفق'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('follow_up_status')
                        ->label('وضعیت پیگیری')
                        ->options(['active' => 'فعال', 'inactive' => 'غیرفعال', 'pending' => 'در انتظار', 'approved' => 'تأیید شده', 'rejected' => 'رد شده', 'completed' => 'تکمیل شده', 'cancelled' => 'لغو شده', 'draft' => 'پیش‌نویس', 'open' => 'باز', 'closed' => 'بسته', 'in_progress' => 'در حال انجام', 'suspended' => 'معلق', 'resolved' => 'حل‌شده', 'failed' => 'ناموفق'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('اطلاعات اصلی')
                ->schema([
                    Forms\Components\TextInput::make('disease_code')
                        ->label('کد بیماری')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('disease_name')
                        ->label('نام بیماری')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('patient_age')
                        ->label('سن بیمار')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\Select::make('patient_gender')
                        ->label('جنسیت بیمار')
                        ->options(['male' => 'مرد', 'female' => 'زن', 'other' => 'سایر', 'unknown' => 'نامشخص'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\TextInput::make('patient_occupation')
                        ->label('شغل بیمار')
                        ->maxLength(255),
                    Forms\Components\Toggle::make('lab_confirmed')
                        ->label('تأیید آزمایشگاهی')
                        ->default(false),
                    Forms\Components\Toggle::make('lab_result')
                        ->label('نتیجه آزمایش')
                        ->default(false),
                    Forms\Components\TextInput::make('contacts_identified')
                        ->label('مخاطبین شناسایی‌شده')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\Toggle::make('contact_tracing_done')
                        ->label('ردیابی مخاطب')
                        ->default(false),
                    Forms\Components\Toggle::make('isolation_applied')
                        ->label('قرنطینه')
                        ->default(false),
                    Forms\Components\TextInput::make('report_source')
                        ->label('منبع گزارش')
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('تاریخ‌ها')
                ->schema([
                    Forms\Components\DatePicker::make('report_date')
                        ->label('تاریخ گزارش')
                        ->native(false),
                    Forms\Components\DatePicker::make('onset_date')
                        ->label('تاریخ شروع علائم')
                        ->native(false),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('اطلاعات تماس و مکان')
                ->schema([
                    Forms\Components\TextInput::make('residence_location')
                        ->label('محل سکونت')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('infection_location')
                        ->label('محل ابتلا')
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('توضیحات')
                ->schema([
                    Forms\Components\Textarea::make('symptoms')
                        ->label('علائم')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('treatment')
                        ->label('درمان')
                        ->rows(3)
                        ->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('center.name')
                    ->label('مرکز')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('case_id')
                    ->label('شناسه پرونده')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('disease_category')
                    ->label('دسته بیماری')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('disease_code')
                    ->label('کد بیماری')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('disease_name')
                    ->label('نام بیماری')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('report_date')
                    ->label('تاریخ گزارش')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('onset_date')
                    ->label('تاریخ شروع علائم')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('patient_age')
                    ->label('سن بیمار')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('patient_gender')
                    ->label('جنسیت بیمار')
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
            'index' => Pages\ListDiseaseSurveillances::route('/'),
            'create' => Pages\CreateDiseaseSurveillance::route('/create'),
            'edit' => Pages\EditDiseaseSurveillance::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
