<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\StaffTransferResource\Pages;
use App\Models\Center;
use App\Models\Employee;
use App\Models\StaffTransfer;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StaffTransferResource extends Resource
{
    protected static ?string $model = StaffTransfer::class;

    protected static ?string $modelLabel = 'انتقال پرسنل';

    protected static ?string $pluralModelLabel = 'انتقال‌های پرسنل';

    protected static ?string $navigationLabel = 'انتقال پرسنل';

    protected static string|\UnitEnum|null $navigationGroup = 'منابع انسانی';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::ArrowsUpDown;

    protected static ?int $navigationSort = 260;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

                public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->schema([
            Section::make('ارتباطات')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('created_by')
                        ->label('ایجادکننده')
                        ->maxLength(255),
                    Forms\Components\Select::make('employee_id')
                        ->label('کارمند')
                        ->relationship(name: 'employee', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\Employee $record) => (string) (($record->first_name ?? null) ?: ($record->last_name ?? null) ?: ($record->personnel_code ?? null) ?: ($record->name ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('from_center_id')
                        ->label('از مرکز')
                        ->relationship(name: 'fromCenter', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\Center $record) => (string) (($record->name ?? null) ?: ($record->code ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('requested_by')
                        ->label('درخواست‌کننده')
                        ->relationship(name: 'requestedBy', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\Employee $record) => (string) (($record->first_name ?? null) ?: ($record->last_name ?? null) ?: ($record->personnel_code ?? null) ?: ($record->name ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('to_center_id')
                        ->label('به مرکز')
                        ->relationship(name: 'toCenter', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\Center $record) => (string) (($record->name ?? null) ?: ($record->code ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\TextInput::make('updated_by')
                        ->label('ویرایش‌کننده')
                        ->maxLength(255),
                ]),
            Section::make('وضعیت و نوع')
                ->columns(1)
                ->schema([
                    Forms\Components\Select::make('status')
                        ->label('وضعیت')
                        ->options(['active' => 'فعال', 'inactive' => 'غیرفعال', 'pending' => 'در انتظار', 'approved' => 'تأیید شده', 'rejected' => 'رد شده', 'completed' => 'تکمیل شده', 'cancelled' => 'لغو شده', 'draft' => 'پیش‌نویس', 'open' => 'باز', 'closed' => 'بسته', 'in_progress' => 'در حال انجام', 'suspended' => 'معلق', 'resolved' => 'حل‌شده', 'failed' => 'ناموفق'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                ]),
            Section::make('تاریخ‌ها')
                ->columns(2)
                ->schema([
                    Forms\Components\DatePicker::make('execution_date')
                        ->label('execution date')
                        ->native(false),
                    Forms\Components\DatePicker::make('request_date')
                        ->label('تاریخ درخواست')
                        ->native(false),
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
                    Forms\Components\Toggle::make('budget_confirmed')
                        ->label('budget confirmed')
                        ->default(false),
                    Forms\Components\Toggle::make('council_confirmation')
                        ->label('council confirmation')
                        ->default(false),
                    Forms\Components\TextInput::make('from_department')
                        ->label('from department')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('gostaresh_review')
                        ->label('gostaresh review')
                        ->maxLength(255),
                    Forms\Components\Toggle::make('health_deputy_approval')
                        ->label('health deputy approval')
                        ->default(false),
                    Forms\Components\Textarea::make('reason')
                        ->label('دلیل')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('to_department')
                        ->label('to department')
                        ->maxLength(255),
                    Forms\Components\Select::make('transfer_type')
                        ->label('transfer type')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                ]),
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
                Tables\Columns\TextColumn::make('employee.first_name')
                    ->label('کارمند')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('request_date')
                    ->label('تاریخ درخواست')
                    ->searchable()
                    ->sortable()
                    ->jalaliDate()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('fromCenter.name')
                    ->label('از مرکز')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('toCenter.name')
                    ->label('به مرکز')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('from_department')
                    ->label('from department')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('to_department')
                    ->label('to department')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('transfer_type')
                    ->label('transfer type')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('reason')
                    ->label('دلیل')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('ایجاد')
                    ->jalaliDateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('وضعیت')
                    ->options(['active' => 'فعال', 'inactive' => 'غیرفعال', 'pending' => 'در انتظار', 'approved' => 'تأیید شده', 'rejected' => 'رد شده', 'completed' => 'تکمیل شده', 'cancelled' => 'لغو شده', 'draft' => 'پیش‌نویس', 'open' => 'باز', 'closed' => 'بسته', 'in_progress' => 'در حال انجام', 'suspended' => 'معلق', 'resolved' => 'حل‌شده', 'failed' => 'ناموفق']),
                Tables\Filters\SelectFilter::make('employee_id')
                    ->label('کارمند')
                    ->relationship('employee', 'id')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\Employee $record) => (string) ((($record->first_name ?? null) ?: ($record->last_name ?? null) ?: ($record->personnel_code ?? null) ?: ($record->name ?? null)) ?: ('#' . $record->getKey())))
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('from_center_id')
                    ->label('از مرکز')
                    ->relationship('fromCenter', 'id')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\Center $record) => (string) ((($record->name ?? null) ?: ($record->code ?? null)) ?: ('#' . $record->getKey())))
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('to_center_id')
                    ->label('به مرکز')
                    ->relationship('toCenter', 'id')
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
            'index' => Pages\ListStaffTransfers::route('/'),
            'create' => Pages\CreateStaffTransfer::route('/create'),
            'edit' => Pages\EditStaffTransfer::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
