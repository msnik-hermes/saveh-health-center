<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PregnantWomanResource\Pages;
use App\Models\PregnantWoman;
use App\Models\Center;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PregnantWomanResource extends Resource
{
    protected static ?string $model = PregnantWoman::class;


    protected static string | NITENUM | NULL $NAVIGATIONGROUP = 'خانواده و جمعیت';

    protected static ?string $navigationLabel = 'مادران باردار';

    protected static ?string $modelLabel = 'مادر باردار';

    protected static ?string $pluralModelLabel = 'مادران باردار';

    protected static ?string $slug = 'pregnant-women';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('اطلاعات هویتی')
                    ->schema([
                        Forms\Components\Select::make('center_id')
                            ->label('مرکز')
                            ->options(fn () => Center::pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                        Forms\Components\TextInput::make('full_name')
                            ->label('نام')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\TextInput::make('national_code')
                            ->label('کد ملی')
                            ->required()
                            ->maxLength(10),
                        Forms\Components\TextInput::make('age')
                            ->label('سن')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('husband_name')
                            ->label('نام همسر')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('phone')
                            ->label('تلفن')
                            ->tel()
                            ->maxLength(15),
                        Forms\Components\TextInput::make('village')
                            ->label('روستا')
                            ->maxLength(100),
                    ])->columns(3),

                Forms\Components\Section::make('اطلاعات بارداری')
                    ->schema([
                        Forms\Components\TextInput::make('gravida')
                            ->label('تعداد حاملگی (G)')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('parity')
                            ->label('تعداد زایمان (P)')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('abortion_count')
                            ->label('سقط')
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('living_children')
                            ->label('فرزندان زنده')
                            ->numeric()
                            ->default(0),
                        Forms\Components\DatePicker::make('lmp_date')
                            ->label('آخرین قاعدگی'),
                        Forms\Components\DatePicker::make('edd_date')
                            ->label('تاریخ زایمان مورد انتظار'),
                        Forms\Components\DatePicker::make('registration_date')
                            ->label('تاریخ ثبت')
                            ->required(),
                        Forms\Components\DatePicker::make('first_anc_date')
                            ->label('اولین مراجعه'),
                    ])->columns(4),

                Forms\Components\Section::make('اطلاعات پزشکی')
                    ->schema([
                        Forms\Components\TextInput::make('blood_type')
                            ->label('گروه خونی')
                            ->maxLength(5),
                        Forms\Components\TextInput::make('rh_factor')
                            ->label('فاکتور Rh')
                            ->maxLength(5),
                        Forms\Components\Textarea::make('medical_history')
                            ->label('سابقه پزشکی')
                            ->rows(2),
                        Forms\Components\Textarea::make('current_medications')
                            ->label('داروها')
                            ->rows(2),
                        Forms\Components\Select::make('tetanus_vaccination')
                            ->label('واکسن تتانوس')
                            ->options([
                                'انجام_شده' => 'انجام شده',
                                'انجام_نشده' => 'انجام نشده',
                            ])
                            ->nullable(),
                        Forms\Components\Toggle::make('iron_supplementation')
                            ->label('مکمل آهن'),
                        Forms\Components\Toggle::make('folic_acid')
                            ->label('فولیک اسید'),
                        Forms\Components\TextInput::make('anc_visits_count')
                            ->label('تعداد مراجعات')
                            ->numeric()
                            ->default(0),
                        Forms\Components\Select::make('status')
                            ->label('وضعیت')
                            ->options([
                                'فعال' => 'فعال',
                                'زایمان_انجام_شده' => 'زایمان انجام شده',
                                'انتقال_یافته' => 'انتقال یافته',
                                'سقط' => 'سقط',
                            ])
                            ->default('فعال')
                            ->required(),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('شماره'),
                Tables\Columns\TextColumn::make('full_name')
                    ->label('نام')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('age')
                    ->label('سن'),
                Tables\Columns\TextColumn::make('center.name')
                    ->label('مرکز')
                    ->sortable(),
                Tables\Columns\TextColumn::make('village')
                    ->label('روستا'),
                Tables\Columns\TextColumn::make('gravida')
                    ->label('G'),
                Tables\Columns\TextColumn::make('parity')
                    ->label('P'),
                Tables\Columns\TextColumn::make('edd_date')
                    ->label('تاریخ زایمان')
                    ->date('Y/m/d'),
                Tables\Columns\TextColumn::make('status')
                    ->label('وضعیت')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'فعال' => 'success',
                        'زایمان_انجام_شده' => 'info',
                        'انتقال_یافته' => 'gray',
                        'سقط' => 'danger',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('وضعیت')
                    ->options([
                        'فعال' => 'فعال',
                        'زایمان_انجام_شده' => 'زایمان انجام شده',
                        'انتقال_یافته' => 'انتقال یافته',
                        'سقط' => 'سقط',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPregnantWomen::route('/'),
            'create' => Pages\CreatePregnantWoman::route('/create'),
            'edit' => Pages\EditPregnantWoman::route('/{record}/edit'),
        ];
    }
}
