<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\ItRequestResource\Pages;
use App\Models\Center;
use App\Models\CenterEquipment;
use App\Models\Employee;
use App\Models\ItRequest;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ItRequestResource extends Resource
{
    protected static ?string $model = ItRequest::class;

    protected static ?string $modelLabel = 'درخواست IT';

    protected static ?string $pluralModelLabel = 'درخواست‌های IT';

    protected static ?string $navigationLabel = 'درخواست‌های IT';

    protected static string|\UnitEnum|null $navigationGroup = 'پشتیبانی و ناوگان';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::ComputerDesktop;

    protected static ?int $navigationSort = 320;

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
                    Forms\Components\Select::make('assigned_to')
                        ->label('واگذار به')
                        ->relationship(name: 'assignedTo', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\Employee $record) => (string) (($record->first_name ?? null) ?: ($record->last_name ?? null) ?: ($record->personnel_code ?? null) ?: ($record->name ?? null) ?: ('#' . $record->getKey())))
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
                        ->required(),
                    Forms\Components\TextInput::make('created_by')
                        ->label('ایجادکننده')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\Select::make('equipment_id')
                        ->label('equipment')
                        ->relationship(name: 'equipment', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\CenterEquipment $record) => (string) (($record->name ?? null) ?: ($record->title ?? null) ?: ($record->code ?? null) ?: ($record->full_name ?? null) ?: ($record->id ?? null) ?: ('#' . $record->getKey())))
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
                    Forms\Components\TextInput::make('updated_by')
                        ->label('ویرایش‌کننده')
                        ->numeric()
                        ->maxLength(255),
                ]),
            Section::make('وضعیت و نوع')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('priority')
                        ->label('اولویت')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'urgent' => 'فوری'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('service_type')
                        ->label('نوع خدمت')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('status')
                        ->label('وضعیت')
                        ->options(['active' => 'فعال', 'inactive' => 'غیرفعال', 'pending' => 'در انتظار', 'approved' => 'تأیید شده', 'rejected' => 'رد شده', 'completed' => 'تکمیل شده', 'cancelled' => 'لغو شده', 'draft' => 'پیش‌نویس', 'open' => 'باز', 'closed' => 'بسته', 'in_progress' => 'در حال انجام', 'suspended' => 'معلق', 'resolved' => 'حل‌شده', 'failed' => 'ناموفق'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                ]),
            Section::make('تاریخ‌ها')
                ->columns(1)
                ->schema([
                    Forms\Components\DatePicker::make('completion_date')
                        ->label('تاریخ تکمیل')
                        ->native(false),
                ]),
            Section::make('توضیحات')
                ->columns(1)
                ->schema([
                    Forms\Components\TextInput::make('error_messages')
                        ->label('error messages')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('notes')
                        ->label('یادداشت')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('problem_description')
                        ->label('problem description')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),
            Section::make('سایر اطلاعات')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('available_time')
                        ->label('available time')
                        ->maxLength(255),
                    Forms\Components\Textarea::make('resolution_notes')
                        ->label('resolution notes')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('screenshots')
                        ->label('screenshots')
                        ->rows(3)
                        ->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('priority')
                    ->label('اولویت')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('center.name')
                    ->label('مرکز')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('requestedBy.first_name')
                    ->label('درخواست‌کننده')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('service_type')
                    ->label('نوع خدمت')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('equipment.name')
                    ->label('equipment')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('problem_description')
                    ->label('problem description')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('error_messages')
                    ->label('error messages')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('screenshots')
                    ->label('screenshots')
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
                Tables\Filters\SelectFilter::make('priority')
                    ->label('اولویت')
                    ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'urgent' => 'فوری']),
                Tables\Filters\SelectFilter::make('center_id')
                    ->label('مرکز')
                    ->relationship('center', 'id')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\Center $record) => (string) ((($record->name ?? null) ?: ($record->code ?? null)) ?: ('#' . $record->getKey())))
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('requested_by')
                    ->label('درخواست‌کننده')
                    ->relationship('requestedBy', 'id')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\Employee $record) => (string) ((($record->first_name ?? null) ?: ($record->last_name ?? null) ?: ($record->personnel_code ?? null) ?: ($record->name ?? null)) ?: ('#' . $record->getKey())))
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('equipment_id')
                    ->label('equipment')
                    ->relationship('equipment', 'id')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\CenterEquipment $record) => (string) ((($record->name ?? null) ?: ($record->title ?? null) ?: ($record->code ?? null) ?: ($record->full_name ?? null) ?: ($record->id ?? null)) ?: ('#' . $record->getKey())))
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
            'index' => Pages\ListItRequests::route('/'),
            'create' => Pages\CreateItRequest::route('/create'),
            'edit' => Pages\EditItRequest::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
