<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\VaccineDrugDistributionResource\Pages;
use App\Models\Center;
use App\Models\VaccineDrug;
use App\Models\VaccineDrugDistribution;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class VaccineDrugDistributionResource extends Resource
{
    protected static ?string $model = VaccineDrugDistribution::class;

    protected static ?string $modelLabel = 'توزیع واکسن/دارو';

    protected static ?string $pluralModelLabel = 'توزیع واکسن و دارو';

    protected static ?string $navigationLabel = 'توزیع واکسن/دارو';

    protected static string|\UnitEnum|null $navigationGroup = 'مالی و انبار';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Truck;

    protected static ?int $navigationSort = 750;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('ارتباطات')
                ->schema([
                    Forms\Components\Select::make('vaccine_drug_id')
                        ->label('vaccine drug')
                        ->relationship(name: 'vaccineDrug', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\VaccineDrug $record) => (string) (($record->name ?? null) ?: ($record->code ?? null) ?: ('#' . $record->getKey())))
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
            Section::make('تاریخ‌ها')
                ->schema([
                    Forms\Components\DatePicker::make('distribution_date')
                        ->label('تاریخ توزیع')
                        ->native(false),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('مالی و مقادیر')
                ->schema([
                    Forms\Components\TextInput::make('quantity_sent')
                        ->label('quantity sent')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('quantity_received')
                        ->label('quantity received')
                        ->numeric()
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('اطلاعات اصلی')
                ->schema([
                    Forms\Components\DatePicker::make('temperature_at_distribution')
                        ->label('temperature at distribution')
                        ->native(false),
                    Forms\Components\TextInput::make('distributor_name')
                        ->label('distributor name')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('recipient_name')
                        ->label('recipient name')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('transport_method')
                        ->label('transport method')
                        ->maxLength(255),
                    Forms\Components\Toggle::make('cold_chain_maintained')
                        ->label('cold chain maintained')
                        ->default(false),
                    Forms\Components\Textarea::make('delivery_receipt')
                        ->label('delivery receipt')
                        ->rows(3)
                        ->columnSpanFull(),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('وضعیت و نوع')
                ->schema([
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
                Tables\Columns\TextColumn::make('vaccineDrug.name')
                    ->label('vaccine drug')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('distribution_date')
                    ->label('تاریخ توزیع')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('quantity_sent')
                    ->label('quantity sent')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('quantity_received')
                    ->label('quantity received')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('temperature_at_distribution')
                    ->label('temperature at distribution')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('distributor_name')
                    ->label('distributor name')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('recipient_name')
                    ->label('recipient name')
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
                Tables\Filters\SelectFilter::make('vaccine_drug_id')
                    ->label('vaccine drug')
                    ->relationship('vaccineDrug', 'id')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\VaccineDrug $record) => (string) ((($record->name ?? null) ?: ($record->code ?? null)) ?: ('#' . $record->getKey())))
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
            'index' => Pages\ListVaccineDrugDistributions::route('/'),
            'create' => Pages\CreateVaccineDrugDistribution::route('/create'),
            'edit' => Pages\EditVaccineDrugDistribution::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
