<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\CompanyInspectionResource\Pages;
use App\Models\Company;
use App\Models\CompanyInspection;
use App\Models\Employee;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CompanyInspectionResource extends Resource
{
    protected static ?string $model = CompanyInspection::class;

    protected static ?string $modelLabel = 'بازدید شرکت';

    protected static ?string $pluralModelLabel = 'بازدیدهای شرکت';

    protected static ?string $navigationLabel = 'بازدید شرکت‌ها';

    protected static string|\UnitEnum|null $navigationGroup = 'بازرسی و ایمنی';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::ClipboardDocumentList;

    protected static ?int $navigationSort = 620;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('ارتباطات')
                ->schema([
                    Forms\Components\Select::make('company_id')
                        ->label('شرکت')
                        ->relationship(name: 'company', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\Company $record) => (string) (($record->name ?? null) ?: ($record->registration_number ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('inspector_id')
                        ->label('بازرس')
                        ->relationship(name: 'inspector', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\Employee $record) => (string) (($record->first_name ?? null) ?: ($record->last_name ?? null) ?: ($record->personnel_code ?? null) ?: ($record->name ?? null) ?: ('#' . $record->getKey())))
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
                    Forms\Components\TextInput::make('company_name')
                        ->label('company name')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('workers_inspected')
                        ->label('workers inspected')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('violations_found')
                        ->label('violations found')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('compliance_score')
                        ->label('compliance score')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('violations')
                        ->label('تخلفات')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('corrective_actions')
                        ->label('corrective actions')
                        ->maxLength(255),
                    Forms\Components\Textarea::make('photos')
                        ->label('photos')
                        ->rows(3)
                        ->columnSpanFull(),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('وضعیت و نوع')
                ->schema([
                    Forms\Components\Select::make('inspection_type')
                        ->label('نوع بازرسی')
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
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('تاریخ‌ها')
                ->schema([
                    Forms\Components\DatePicker::make('inspection_date')
                        ->label('تاریخ بازرسی')
                        ->native(false),
                    Forms\Components\DatePicker::make('next_inspection_date')
                        ->label('next inspection date')
                        ->native(false),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('توضیحات')
                ->schema([
                    Forms\Components\Textarea::make('findings')
                        ->label('یافته‌ها')
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
                Tables\Columns\TextColumn::make('status')
                    ->label('وضعیت')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('company.name')
                    ->label('شرکت')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('inspection_date')
                    ->label('تاریخ بازرسی')
                    ->searchable()
                    ->sortable()
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('company_name')
                    ->label('company name')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('inspector.first_name')
                    ->label('بازرس')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('inspection_type')
                    ->label('نوع بازرسی')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('workers_inspected')
                    ->label('workers inspected')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('findings')
                    ->label('یافته‌ها')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('violations_found')
                    ->label('violations found')
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
                Tables\Filters\SelectFilter::make('company_id')
                    ->label('شرکت')
                    ->relationship('company', 'id')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\Company $record) => (string) ((($record->name ?? null) ?: ($record->registration_number ?? null)) ?: ('#' . $record->getKey())))
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('inspector_id')
                    ->label('بازرس')
                    ->relationship('inspector', 'id')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\Employee $record) => (string) ((($record->first_name ?? null) ?: ($record->last_name ?? null) ?: ($record->personnel_code ?? null) ?: ($record->name ?? null)) ?: ('#' . $record->getKey())))
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
            'index' => Pages\ListCompanyInspections::route('/'),
            'create' => Pages\CreateCompanyInspection::route('/create'),
            'edit' => Pages\EditCompanyInspection::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
