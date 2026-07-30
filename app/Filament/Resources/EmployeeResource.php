<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Models\Employee;
use App\Models\Center;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'کارگزینی';

    protected static ?string $navigationLabel = 'کارکنان';

    protected static ?string $modelLabel = 'کارمند';

    protected static ?string $pluralModelLabel = 'کارکنان';

    protected static ?string $recordTitleAttribute = 'last_name';

    protected static ?string $slug = 'employees';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('اطلاعات هویتی')
                    ->schema([
                        Forms\Components\TextInput::make('personnel_code')
                            ->label('کد پرسنلی')
                            ->required()
                            ->maxLength(20),
                        Forms\Components\TextInput::make('first_name')
                            ->label('نام')
                            ->required()
                            ->maxLength(50),
                        Forms\Components\TextInput::make('last_name')
                            ->label('نام خانوادگی')
                            ->required()
                            ->maxLength(50),
                        Forms\Components\TextInput::make('father_name')
                            ->label('نام پدر')
                            ->maxLength(50),
                        Forms\Components\TextInput::make('national_code')
                            ->label('کد ملی')
                            ->required()
                            ->maxLength(10),
                        Forms\Components\TextInput::make('birth_date')
                            ->label('تاریخ تولد')
                            ->date()
                            ->required(),
                        Forms\Components\Select::make('gender')
                            ->label('جنسیت')
                            ->options([
                                'مرد' => 'مرد',
                                'زن' => 'زن',
                            ])
                            ->required(),
                        Forms\Components\Select::make('marital_status')
                            ->label('وضعیت تأهل')
                            ->options([
                                'مجرد' => 'مجرد',
                                'متاهل' => 'متاهل',
                                'مطلقه' => 'مطلقه',
                                'بیوه' => 'بیوه',
                            ])
                            ->required(),
                    ])->columns(3),

                Forms\Components\Section::make('اطلاعات شغلی')
                    ->schema([
                        Forms\Components\TextInput::make('job_title')
                            ->label('عنوان شغلی')
                            ->required()
                            ->maxLength(200),
                        Forms\Components\TextInput::make('position')
                            ->label('سمت')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\Select::make('employment_type')
                            ->label('نوع استخدام')
                            ->options([
                                'رسمی' => 'رسمی',
                                'پیمانی' => 'پیمانی',
                                'تبصره_۳' => 'تبصره ۳',
                                'تبصره_۴' => 'تبصره ۴',
                                'پیمانکاری' => 'پیمانکاری',
                                'شرکتی' => 'شرکتی',
                                'طرحی' => 'طرحی',
                                'سربازی' => 'سربازی',
                                'ماده_۳۲' => 'ماده ۳۲',
                            ])
                            ->required(),
                        Forms\Components\DatePicker::make('employment_date')
                            ->label('تاریخ شروع')
                            ->required(),
                        Forms\Components\Select::make('center_id')
                            ->label('مرکز')
                            ->options(fn () => Center::pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                        Forms\Components\TextInput::make('department')
                            ->label('واحد سازمانی')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\Select::make('service_type')
                            ->label('نوع خدمت')
                            ->options([
                                'درمانی' => 'درمانی',
                                'اداری' => 'اداری',
                                'فنی' => 'فنی',
                                'خدماتی' => 'خدماتی',
                            ])
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->label('وضعیت')
                            ->options([
                                'فعال' => 'فعال',
                                'مرخصی' => 'مرخصی',
                                'بازنشسته' => 'بازنشسته',
                                'انتقال‌یافته' => 'انتقال یافته',
                                'اخراجی' => 'اخراجی',
                            ])
                            ->default('فعال')
                            ->required(),
                    ])->columns(3),

                Forms\Components\Section::make('اطلاعات تحصیلی')
                    ->schema([
                        Forms\Components\TextInput::make('education_degree')
                            ->label('مدرک تحصیلی')
                            ->required()
                            ->maxLength(50),
                        Forms\Components\TextInput::make('education_field')
                            ->label('رشته تحصیلی')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('university')
                            ->label('دانشگاه')
                            ->maxLength(200),
                        Forms\Components\TextInput::make('graduation_year')
                            ->label('سال فارغ‌التحصیلی')
                            ->numeric(),
                        Forms\Components\TextInput::make('gpa')
                            ->label('معدل')
                            ->numeric()
                            ->decimalDigits(2),
                    ])->columns(3),

                Forms\Components\Section::make('اطلاعات تماس')
                    ->schema([
                        Forms\Components\TextInput::make('mobile')
                            ->label('موبایل')
                            ->tel()
                            ->required()
                            ->maxLength(15),
                        Forms\Components\TextInput::make('work_email')
                            ->label('ایمیل کاری')
                            ->email()
                            ->maxLength(100),
                        Forms\Components\TextInput::make('emergency_contact')
                            ->label('تماس اضطراری')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('emergency_phone')
                            ->label('تلفن اضطراری')
                            ->tel()
                            ->maxLength(15),
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
                Tables\Columns\TextColumn::make('personnel_code')
                    ->label('کد پرسنلی')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('first_name')
                    ->label('نام')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->label('نام خانوادگی')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('job_title')
                    ->label('عنوان شغلی')
                    ->searchable(),
                Tables\Columns\TextColumn::make('center.name')
                    ->label('مرکز')
                    ->sortable(),
                Tables\Columns\TextColumn::make('department')
                    ->label('واحد'),
                Tables\Columns\TextColumn::make('employment_type')
                    ->label('نوع استخدام'),
                Tables\Columns\TextColumn::make('mobile')
                    ->label('موبایل'),
                Tables\Columns\TextColumn::make('status')
                    ->label('وضعیت')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'فعال' => 'success',
                        'مرخصی' => 'warning',
                        'بازنشسته' => 'gray',
                        'انتقال‌یافته' => 'info',
                        'اخراجی' => 'danger',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('وضعیت')
                    ->options([
                        'فعال' => 'فعال',
                        'مرخصی' => 'مرخصی',
                        'بازنشسته' => 'بازنشسته',
                        'انتقال‌یافته' => 'انتقال یافته',
                        'اخراجی' => 'اخراجی',
                    ]),
                Tables\Filters\SelectFilter::make('center_id')
                    ->label('مرکز')
                    ->options(fn () => Center::pluck('name', 'id')),
                Tables\Filters\SelectFilter::make('employment_type')
                    ->label('نوع استخدام')
                    ->options([
                        'رسمی' => 'رسمی',
                        'پیمانی' => 'پیمانی',
                        'تبصره_۳' => 'تبصره ۳',
                        'تبصره_۴' => 'تبصره ۴',
                        'پیمانکاری' => 'پیمانکاری',
                        'شرکتی' => 'شرکتی',
                        'طرحی' => 'طرحی',
                        'سربازی' => 'سربازی',
                        'ماده_۳۲' => 'ماده ۳۲',
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
