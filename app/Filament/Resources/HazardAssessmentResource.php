<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HazardAssessmentResource\Pages;
use App\Models\HazardAssessment;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;
use Filament\Actions;

class HazardAssessmentResource extends Resource
{
    protected static ?string $model = HazardAssessment::class;
    protected static ?string $modelLabel = 'ارزیابی خطر';
    protected static ?string $pluralModelLabel = 'ارزیابی‌های خطر';
    protected static ?string $navigationLabel = 'ارزیابی خطر';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('اطلاعات پایه')
                ->schema([
                    Forms\Components\TextInput::make('company_name')
                        ->label('نام شرکت')
                        ->required()
                        ->maxLength(200),
                    Forms\Components\DatePicker::make('assessment_date')
                        ->label('تاریخ ارزیابی')
                        ->required(),
                    Forms\Components\TextInput::make('assessor_name')
                        ->label('نام ارزیاب')
                        ->required()
                        ->maxLength(100),
                    Forms\Components\TextInput::make('assessor_qualifications')
                        ->label('صلاحیت ارزیاب')
                        ->maxLength(200),
                    Forms\Components\TextInput::make('job_title_assessed')
                        ->label('عنوان شغلی ارزیابی شده')
                        ->required()
                        ->maxLength(100),
                ])->columns(2),

            Section::make('اطلاعات شغلی')
                ->schema([
                    Forms\Components\TextInput::make('workers_in_job')
                        ->label('تعداد کارگران')
                        ->numeric(),
                    Forms\Components\TextInput::make('daily_work_hours')
                        ->label('ساعات کار روزانه')
                        ->numeric(),
                    Forms\Components\TextInput::make('weekly_work_days')
                        ->label('روزهای کار هفتگی')
                        ->numeric(),
                ])->columns(3),

            Section::make('دسته‌بندی خطرات')
                ->schema([
                    Forms\Components\Textarea::make('hazard_categories')
                        ->label('دسته‌بندی خطرات')
                        ->rows(3),
                    Forms\Components\Textarea::make('physical_hazards')
                        ->label('خطرات فیزیکی')
                        ->rows(3),
                    Forms\Components\Textarea::make('chemical_hazards')
                        ->label('خطرات شیمیایی')
                        ->rows(3),
                    Forms\Components\Textarea::make('biological_hazards')
                        ->label('خطرات بیولوژیکی')
                        ->rows(3),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company_name')
                    ->label('شرکت')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('assessment_date')
                    ->label('تاریخ')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('assessor_name')
                    ->label('ارزیاب')
                    ->searchable(),
                Tables\Columns\TextColumn::make('job_title_assessed')
                    ->label('شغل'),
                Tables\Columns\TextColumn::make('workers_in_job')
                    ->label('کارگران')
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
            'index' => Pages\ListHazardAssessments::route('/'),
            'create' => Pages\CreateHazardAssessment::route('/create'),
            'edit' => Pages\EditHazardAssessment::route('/{record}/edit'),
        ];
    }
}
