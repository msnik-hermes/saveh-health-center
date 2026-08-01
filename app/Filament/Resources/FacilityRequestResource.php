<?php

namespace App\Filament\Resources;

use App\Models\FacilityRequest;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;

class FacilityRequestResource extends Resource
{
    protected static ?string $model = FacilityRequest::class;
    protected static ?string $modelLabel = 'درخواست تاسیسات';
    protected static ?string $pluralModelLabel = 'درخواست‌های تاسیسات';
    protected static ?string $navigationLabel = 'درخواست‌های تاسیسات';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\TextInput::make('request_type')
                ->label('نوع درخواست')
                ->required()
                ->maxLength(100),
            Forms\Components\TextInput::make('description')
                ->label('توضیحات')
                ->required()
                ->maxLength(1000),
            Forms\Components\Select::make('priority')
                ->label('اولویت')
                ->options([
                    'low' => 'کم',
                    'medium' => 'متوسط',
                    'high' => 'بالا',
                    'urgent' => 'فوری',
                ])
                ->required()
                ->default('medium'),
            Forms\Components\Select::make('status')
                ->label('وضعیت')
                ->options([
                    'pending' => 'در انتظار',
                    'approved' => 'تایید شده',
                    'rejected' => 'رد شده',
                    'completed' => 'تکمیل شده',
                ])
                ->required()
                ->default('pending'),
            Forms\Components\TextInput::make('requested_by')
                ->label('درخواست‌کننده')
                ->required()
                ->maxLength(255),
            Forms\Components\DatePicker::make('request_date')
                ->label('تاریخ درخواست')
                ->required(),
            Forms\Components\Textarea::make('notes')
                ->label('یادداشت‌ها')
                ->rows(3)
                ->maxLength(500),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('request_type')
                    ->label('نوع درخواست')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('توضیحات')
                    ->limit(100),
                Tables\Columns\TextColumn::make('priority')
                    ->label('اولویت')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'low' => 'success',
                        'medium' => 'info',
                        'high' => 'warning',
                        'urgent' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->label('وضعیت')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'completed' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'در انتظار',
                        'approved' => 'تایید شده',
                        'rejected' => 'رد شده',
                        'completed' => 'تکمیل شده',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('requested_by')
                    ->label('درخواست‌کننده'),
                Tables\Columns\TextColumn::make('request_date')
                    ->label('تاریخ درخواست')
                    ->date()
                    ->sortable(),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFacilityRequests::route('/'),
            'create' => Pages\CreateFacilityRequest::route('/create'),
            'edit' => Pages\EditFacilityRequest::route('/{record}/edit'),
        ];
    }
}
