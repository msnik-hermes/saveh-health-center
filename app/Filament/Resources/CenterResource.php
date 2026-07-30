<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CenterResource\Pages;
use App\Models\Center;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class CenterResource extends Resource
{
    protected static ?string $model = Center::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationGroup = 'مدیریت';

    protected static ?string $navigationLabel = 'مراکز';

    protected static ?string $modelLabel = 'مرکز';

    protected static ?string $pluralModelLabel = 'مراکز';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $slug = 'centers';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('اطلاعات اصلی')
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->label('کد مرکز')
                            ->required()
                            ->maxLength(50),
                        Forms\Components\TextInput::make('name')
                            ->label('نام مرکز')
                            ->required()
                            ->maxLength(200),
                        Forms\Components\Select::make('type')
                            ->label('نوع مرکز')
                            ->options([
                                'خانه_بهداشت' => 'خانه بهداشت',
                                'مرکز_جامع' => 'مرکز جامع',
                                'پایگاه_سلامت' => 'پایگاه سلامت',
                                'مرکز_بهداشت' => 'مرکز بهداشت',
                                'درمانگاه' => 'درمانگاه',
                                'کلینیک' => 'کلینیک',
                            ])
                            ->required(),
                        Forms\Components\Select::make('parent_id')
                            ->label('مرکز والد')
                            ->options(fn () => Center::pluck('name', 'id'))
                            ->searchable()
                            ->nullable(),
                        Forms\Components\TextInput::make('level')
                            ->label('سطح سلسله‌مراتبی')
                            ->numeric()
                            ->default(1)
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('اطلاعات مکانی')
                    ->schema([
                        Forms\Components\TextInput::make('university')
                            ->label('دانشگاه علوم پزشکی')
                            ->maxLength(200),
                        Forms\Components\TextInput::make('province')
                            ->label('استان')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('city')
                            ->label('شهرستان')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('district')
                            ->label('بخش')
                            ->maxLength(100),
                        Forms\Components\Textarea::make('address')
                            ->label('آدرس کامل')
                            ->rows(3),
                        Forms\Components\TextInput::make('postal_code')
                            ->label('کد پستی')
                            ->maxLength(10),
                        Forms\Components\TextInput::make('gps_lat')
                            ->label('عرض جغرافیایی')
                            ->numeric()
                            ->decimalDigits(8),
                        Forms\Components\TextInput::make('gps_lng')
                            ->label('طول جغرافیایی')
                            ->numeric()
                            ->decimalDigits(8),
                    ])->columns(2),

                Forms\Components\Section::make('اطلاعات تماس')
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->label('تلفن اصلی')
                            ->tel()
                            ->maxLength(20),
                        Forms\Components\TextInput::make('fax')
                            ->label('فکس')
                            ->maxLength(20),
                        Forms\Components\TextInput::make('email')
                            ->label('ایمیل')
                            ->email()
                            ->maxLength(100),
                        Forms\Components\TextInput::make('website')
                            ->label('وب‌سایت')
                            ->url()
                            ->maxLength(200),
                    ])->columns(2),

                Forms\Components\Section::make('اطلاعات ساختمان')
                    ->schema([
                        Forms\Components\TextInput::make('population_served')
                            ->label('جمعیت تحت پوشش')
                            ->numeric(),
                        Forms\Components\Select::make('service_area_type')
                            ->label('نوع منطقه خدمت')
                            ->options([
                                'شهری' => 'شهری',
                                'روستایی' => 'روستایی',
                                'هر دو' => 'هر دو',
                            ]),
                        Forms\Components\TextInput::make('area_sqm')
                            ->label('متراژ ساختمان (متر مربع)')
                            ->numeric()
                            ->decimalDigits(2),
                        Forms\Components\TextInput::make('floors')
                            ->label('تعداد طبقات')
                            ->numeric(),
                        Forms\Components\TextInput::make('rooms_count')
                            ->label('تعداد اتاق‌ها')
                            ->numeric(),
                        Forms\Components\TextInput::make('parking_spaces')
                            ->label('ظرفیت پارکینگ')
                            ->numeric(),
                        Forms\Components\Select::make('building_type')
                            ->label('نوع ساختمان')
                            ->options([
                                'ملکی' => 'ملکی',
                                'اجاره‌ای' => 'اجاره‌ای',
                                'دولتی' => 'دولتی',
                            ]),
                    ])->columns(3),

                Forms\Components\Section::make('امکانات')
                    ->schema([
                        Forms\Components\Toggle::make('has_elevator')
                            ->label('آسانسور')
                            ->default(false),
                        Forms\Components\Toggle::make('has_generator')
                            ->label('ژنراتور')
                            ->default(false),
                        Forms\Components\TextInput::make('generator_power_kw')
                            ->label('توان ژنراتور (کیلووات)')
                            ->numeric()
                            ->decimalDigits(2),
                        Forms\Components\Toggle::make('has_fire_system')
                            ->label('سیستم اطفاء حریق')
                            ->default(false),
                        Forms\Components\Toggle::make('has_cctv')
                            ->label('دوربین مداربسته')
                            ->default(false),
                    ])->columns(3),

                Forms\Components\Section::make('وضعیت و مدیریت')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('وضعیت')
                            ->options([
                                'فعال' => 'فعال',
                                'غیرفعال' => 'غیرفعال',
                                'در_حال_تعمیر' => 'در حال تعمیر',
                            ])
                            ->default('فعال')
                            ->required(),
                        Forms\Components\DatePicker::make('established_date')
                            ->label('تاریخ تأسیس'),
                        Forms\Components\TextInput::make('license_number')
                            ->label('شماره پروانه')
                            ->maxLength(100),
                        Forms\Components\DatePicker::make('license_expiry')
                            ->label('تاریخ انقضای پروانه'),
                        Forms\Components\TextInput::make('accreditation_level')
                            ->label('سطح اعتباربخشی')
                            ->maxLength(50),
                        Forms\Components\Textarea::make('notes')
                            ->label('یادداشت‌ها')
                            ->rows(3),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('کد')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('نام مرکز')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('نوع')
                    ->badge(),
                Tables\Columns\TextColumn::make('city')
                    ->label('شهرستان')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('تلفن'),
                Tables\Columns\TextColumn::make('status')
                    ->label('وضعیت')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'فعال' => 'success',
                        'غیرفعال' => 'danger',
                        'در_حال_تعمیر' => 'warning',
                    }),
                Tables\Columns\TextColumn::make('population_served')
                    ->label('جمعیت تحت پوشش')
                    ->numeric(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('وضعیت')
                    ->options([
                        'فعال' => 'فعال',
                        'غیرفعال' => 'غیرفعال',
                        'در_حال_تعمیر' => 'در حال تعمیر',
                    ]),
                Tables\Filters\SelectFilter::make('type')
                    ->label('نوع مرکز')
                    ->options([
                        'خانه_بهداشت' => 'خانه بهداشت',
                        'مرکز_جامع' => 'مرکز جامع',
                        'پایگاه_سلامت' => 'پایگاه سلامت',
                        'مرکز_بهداشت' => 'مرکز بهداشت',
                        'درمانگاه' => 'درمانگاه',
                        'کلینیک' => 'کلینیک',
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('اطلاعات مرکز')
                    ->schema([
                        Infolists\Components\TextEntry::make('code')->label('کد مرکز'),
                        Infolists\Components\TextEntry::make('name')->label('نام مرکز'),
                        Infolists\Components\TextEntry::make('type')->label('نوع'),
                        Infolists\Components\TextEntry::make('status')->label('وضعیت'),
                        Infolists\Components\TextEntry::make('phone')->label('تلفن'),
                        Infolists\Components\TextEntry::make('address')->label('آدرس'),
                    ])->columns(3),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCenters::route('/'),
            'create' => Pages\CreateCenter::route('/create'),
            'edit' => Pages\EditCenter::route('/{record}/edit'),
        ];
    }
}
