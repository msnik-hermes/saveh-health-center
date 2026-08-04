<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\ReferralResource\Pages;
use App\Models\Center;
use App\Models\Referral;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ReferralResource extends Resource
{
    protected static ?string $model = Referral::class;

    protected static ?string $modelLabel = 'ارجاع';

    protected static ?string $pluralModelLabel = 'ارجاع‌ها';

    protected static ?string $navigationLabel = 'ارجاع‌ها';

    protected static string|\UnitEnum|null $navigationGroup = 'سلامت و درمان';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::ArrowTopRightOnSquare;

    protected static ?int $navigationSort = 570;

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
                    Forms\Components\TextInput::make('referring_clinician')
                        ->label('referring clinician')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('referring_unit')
                        ->label('referring unit')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('urgency')
                        ->label('urgency')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('referred_to_facility')
                        ->label('referred to facility')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('referred_to_specialty')
                        ->label('referred to specialty')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('referred_to_clinician')
                        ->label('referred to clinician')
                        ->maxLength(255),
                    Forms\Components\Textarea::make('documentation_sent')
                        ->label('documentation sent')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Toggle::make('patient_attended')
                        ->label('patient attended')
                        ->default(false),
                    Forms\Components\Toggle::make('report_received')
                        ->label('report received')
                        ->default(false),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('تاریخ‌ها')
                ->schema([
                    Forms\Components\Toggle::make('referral_date')
                        ->label('تاریخ ارجاع')
                        ->default(false),
                    Forms\Components\DatePicker::make('appointment_date')
                        ->label('appointment date')
                        ->native(false),
                    Forms\Components\DatePicker::make('report_date')
                        ->label('تاریخ گزارش')
                        ->native(false),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('توضیحات')
                ->schema([
                    Forms\Components\Textarea::make('reason')
                        ->label('دلیل')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\DatePicker::make('non_attendance_reason')
                        ->label('non attendance reason')
                        ->native(false),
                    Forms\Components\Textarea::make('notes')
                        ->label('یادداشت')
                        ->rows(3)
                        ->columnSpanFull(),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('وضعیت و نوع')
                ->schema([
                    Forms\Components\Select::make('outcome')
                        ->label('پیامد')
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
                Tables\Columns\TextColumn::make('patient_national_code')
                    ->label('patient national code')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('referral_date')
                    ->label('تاریخ ارجاع')
                    ->boolean()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('referring_clinician')
                    ->label('referring clinician')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('referring_unit')
                    ->label('referring unit')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('reason')
                    ->label('دلیل')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('urgency')
                    ->label('urgency')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('referred_to_facility')
                    ->label('referred to facility')
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
                Tables\Filters\TernaryFilter::make('referral_date')->label('تاریخ ارجاع'),
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
            'index' => Pages\ListReferrals::route('/'),
            'create' => Pages\CreateReferral::route('/create'),
            'edit' => Pages\EditReferral::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
