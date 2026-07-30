<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DiseaseSurveillanceResource\Pages;
use App\Models\DiseaseSurveillance;
use App\Models\Center;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DiseaseSurveillanceResource extends Resource
{
    protected static ?string $model = DiseaseSurveillance::class;

    protected static ?string $navigationIcon = 'heroicon-o-virus';

    protected static ?string $navigationGroup = 'بیماری‌ها';

    protected static ?string $navigationLabel = 'پایش بیماری‌ها';

    protected static ?string $modelLabel = 'پایش بیماری';

    protected static ?string $pluralModelLabel = 'پایش‌های بیماری';

    protected static ?string $slug = 'disease-surveillance';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('اطلاعات پرونده')
                    ->schema([
                        Forms\Components\Select::make('center_id')
                            ->label('مرکز')
                            ->options(fn () => Center::pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                        Forms\Components\TextInput::make('case_id')
                            ->label('شماره پرونده')
                            ->required()
                            ->maxLength(20),
                        Forms\Components\Select::make('disease_category')
                            ->label('دسته‌بندی بیماری')
                            ->options([
                                'قرنطینه‌ای' => 'قرنطینه‌ای',
                                'گزارشی' => 'گزارشی',
                                'اولویت‌دار' => 'اولویت‌دار',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('disease_code')
                            ->label('کد بیماری')
                            ->required()
                            ->maxLength(20),
                        Forms\Components\TextInput::make('disease_name')
                            ->label('نام بیماری')
                            ->required()
                            ->maxLength(200),
                    ])->columns(3),

                Forms\Components\Section::make('اطلاعات بیمار')
                    ->schema([
                        Forms\Components\DatePicker::make('report_date')
                            ->label('تاریخ گزارش')
                            ->required(),
                        Forms\Components\DatePicker::make('onset_date')
                            ->label('تاریخ شروع'),
                        Forms\Components\TextInput::make('patient_age')
                            ->label('سن')
                            ->numeric(),
                        Forms\Components\Select::make('patient_gender')
                            ->label('جنسیت')
                            ->options([
                                'مرد' => 'مرد',
                                'زن' => 'زن',
                            ]),
                        Forms\Components\TextInput::make('patient_occupation')
                            ->label('شغل')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('residence_location')
                            ->label('محل سکونت')
                            ->maxLength(200),
                        Forms\Components\TextInput::make('infection_location')
                            ->label('محل ابتلا')
                            ->maxLength(200),
                    ])->columns(4),

                Forms\Components\Section::make('تشخیص و درمان')
                    ->schema([
                        Forms\Components\Textarea::make('symptoms')
                            ->label('علائم')
                            ->rows(2),
                        Forms\Components\Toggle::make('lab_confirmed')
                            ->label('تأیید آزمایشگاهی')
                            ->default(false),
                        Forms\Components\Textarea::make('lab_result')
                            ->label('نتیجه آزمایش')
                            ->rows(2),
                        Forms\Components\Select::make('severity')
                            ->label('شدت')
                            ->options([
                                'خفیف' => 'خفیف',
                                'متوسط' => 'متوسط',
                                'شدید' => 'شدید',
                                'مرگبار' => 'مرگبار',
                            ])
                            ->nullable(),
                        Forms\Components\Textarea::make('treatment')
                            ->label('درمان')
                            ->rows(2),
                        Forms\Components\Select::make('outcome')
                            ->label('نتیجه')
                            ->options([
                                'بهبود' => 'بهبود',
                                'در_حال_درمان' => 'در حال درمان',
                                'فوت' => 'فوت',
                            ])
                            ->nullable(),
                    ])->columns(2),

                Forms\Components\Section::make('پیگیری')
                    ->schema([
                        Forms\Components\TextInput::make('contacts_identified')
                            ->label('تعداد تماس‌ها')
                            ->numeric()
                            ->default(0),
                        Forms\Components\Toggle::make('contact_tracing_done')
                            ->label('ردیابی تماس'),
                        Forms\Components\Toggle::make('isolation_applied')
                            ->label('قرنطینه'),
                        Forms\Components\TextInput::make('report_source')
                            ->label('منبع گزارش')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('follow_up_status')
                            ->label('وضعیت پیگیری')
                            ->maxLength(100),
                        Forms\Components\Textarea::make('notes')
                            ->label('یادداشت‌ها')
                            ->rows(2),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('شماره'),
                Tables\Columns\TextColumn::make('case_id')
                    ->label('شماره پرونده')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('disease_name')
                    ->label('نام بیماری')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('disease_category')
                    ->label('دسته')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'قرنطینه‌ای' => 'danger',
                        'گزارشی' => 'warning',
                        'اولویت‌دار' => 'info',
                    }),
                Tables\Columns\TextColumn::make('center.name')
                    ->label('مرکز')
                    ->sortable(),
                Tables\Columns\TextColumn::make('report_date')
                    ->label('تاریخ گزارش')
                    ->date('Y/m/d')
                    ->sortable(),
                Tables\Columns\TextColumn::make('severity')
                    ->label('شدت')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'خفیف' => 'gray',
                        'متوسط' => 'warning',
                        'شدید' => 'danger',
                        'مرگبار' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('lab_confirmed')
                    ->label('آزمایشگاهی')
                    ->boolean(),
                Tables\Columns\TextColumn::make('outcome')
                    ->label('نتیجه')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'بهبود' => 'success',
                        'در_حال_درمان' => 'warning',
                        'فوت' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('disease_category')
                    ->label('دسته‌بندی')
                    ->options([
                        'قرنطینه‌ای' => 'قرنطینه‌ای',
                        'گزارشی' => 'گزارشی',
                        'اولویت‌دار' => 'اولویت‌دار',
                    ]),
                Tables\Filters\SelectFilter::make('severity')
                    ->label('شدت')
                    ->options([
                        'خفیف' => 'خفیف',
                        'متوسط' => 'متوسط',
                        'شدید' => 'شدید',
                        'مرگبار' => 'مرگبار',
                    ]),
                Tables\Filters\SelectFilter::make('outcome')
                    ->label('نتیجه')
                    ->options([
                        'بهبود' => 'بهبود',
                        'در_حال_درمان' => 'در حال درمان',
                        'فوت' => 'فوت',
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
            'index' => Pages\ListDiseaseSurveillances::route('/'),
            'create' => Pages\CreateDiseaseSurveillance::route('/create'),
            'edit' => Pages\EditDiseaseSurveillance::route('/{record}/edit'),
        ];
    }
}
