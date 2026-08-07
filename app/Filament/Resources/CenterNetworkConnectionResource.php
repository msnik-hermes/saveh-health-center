<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\CenterNetworkConnectionResource\Pages;
use App\Models\Center;
use App\Models\CenterNetworkConnection;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CenterNetworkConnectionResource extends Resource
{
    protected static ?string $model = CenterNetworkConnection::class;

    protected static ?string $modelLabel = 'اتصال شبکه';

    protected static ?string $pluralModelLabel = 'اتصالات شبکه';

    protected static ?string $navigationLabel = 'اتصالات شبکه';

    protected static string|\UnitEnum|null $navigationGroup = 'سازمان';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Signal;

    protected static ?int $navigationSort = 200;

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
                    Forms\Components\Select::make('connection_type')
                        ->label('نوع اتصال')
                        ->options(['low' => 'کم', 'medium' => 'متوسط', 'high' => 'بالا', 'critical' => 'بحرانی', 'general' => 'عمومی', 'special' => 'تخصصی', 'other' => 'سایر'])
                        ->searchable()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\TextInput::make('contract_number')
                        ->label('contract number')
                        ->maxLength(255),
                    Forms\Components\Textarea::make('ip_address')
                        ->label('آدرس IP')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('provider')
                        ->label('اپراتور')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('speed_download')
                        ->label('speed download')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('speed_upload')
                        ->label('speed upload')
                        ->numeric()
                        ->maxLength(255),
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
                Tables\Columns\TextColumn::make('center.name')
                    ->label('مرکز')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('connection_type')
                    ->label('نوع اتصال')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('provider')
                    ->label('اپراتور')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('speed_download')
                    ->label('speed download')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('speed_upload')
                    ->label('speed upload')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('آدرس IP')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('contract_number')
                    ->label('contract number')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('notes')
                    ->label('یادداشت')
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
            'index' => Pages\ListCenterNetworkConnections::route('/'),
            'create' => Pages\CreateCenterNetworkConnection::route('/create'),
            'edit' => Pages\EditCenterNetworkConnection::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
