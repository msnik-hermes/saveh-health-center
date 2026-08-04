<?php

namespace App\Filament\Resources;

use Filament\Support\Icons\Heroicon;

use App\Filament\Resources\PerformanceEvaluationResource\Pages;
use App\Models\Employee;
use App\Models\PerformanceEvaluation;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PerformanceEvaluationResource extends Resource
{
    protected static ?string $model = PerformanceEvaluation::class;

    protected static ?string $modelLabel = 'ارزیابی عملکرد';

    protected static ?string $pluralModelLabel = 'ارزیابی‌های عملکرد';

    protected static ?string $navigationLabel = 'ارزیابی عملکرد';

    protected static string|\UnitEnum|null $navigationGroup = 'منابع انسانی';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::ChartBarSquare;

    protected static ?int $navigationSort = 250;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('ارتباطات')
                ->schema([
                    Forms\Components\Select::make('employee_id')
                        ->label('کارمند')
                        ->relationship(name: 'employee', titleAttribute: 'id')
                        ->getOptionLabelFromRecordUsing(fn (\App\Models\Employee $record) => (string) (($record->first_name ?? null) ?: ($record->last_name ?? null) ?: ($record->personnel_code ?? null) ?: ($record->name ?? null) ?: ('#' . $record->getKey())))
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->nullable(),
                    Forms\Components\Select::make('evaluator_id')
                        ->label('ارزیاب')
                        ->relationship(name: 'evaluator', titleAttribute: 'id')
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
                    Forms\Components\TextInput::make('evaluation_period')
                        ->label('دوره ارزیابی')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('self_score')
                        ->label('self score')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('supervisor_score')
                        ->label('supervisor score')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('peer_score')
                        ->label('peer score')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('overall_score')
                        ->label('امتیاز کل')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('job_knowledge')
                        ->label('job knowledge')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('quality_of_work')
                        ->label('quality of work')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('punctuality')
                        ->label('punctuality')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('teamwork')
                        ->label('teamwork')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('initiative')
                        ->label('initiative')
                        ->numeric()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('strengths')
                        ->label('نقاط قوت')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('improvement_areas')
                        ->label('improvement areas')
                        ->maxLength(255),
                    Forms\Components\Toggle::make('promotion_recommendation')
                        ->label('promotion recommendation')
                        ->default(false),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('وضعیت و نوع')
                ->schema([
                    Forms\Components\Select::make('evaluation_type')
                        ->label('evaluation type')
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
            Section::make('مالی و مقادیر')
                ->schema([
                    Forms\Components\TextInput::make('quantity_of_work')
                        ->label('quantity of work')
                        ->numeric()
                        ->maxLength(255),
                ])
                ->columns(2)
                ->collapsible(),
            Section::make('توضیحات')
                ->schema([
                    Forms\Components\Textarea::make('development_goals')
                        ->label('development goals')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('training_recommendations')
                        ->label('training recommendations')
                        ->rows(3)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('comments')
                        ->label('comments')
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
                Tables\Columns\TextColumn::make('employee.first_name')
                    ->label('کارمند')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('evaluation_period')
                    ->label('دوره ارزیابی')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('evaluation_type')
                    ->label('evaluation type')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('evaluator.first_name')
                    ->label('ارزیاب')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('self_score')
                    ->label('self score')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('supervisor_score')
                    ->label('supervisor score')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('peer_score')
                    ->label('peer score')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('overall_score')
                    ->label('امتیاز کل')
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
                Tables\Filters\SelectFilter::make('employee_id')
                    ->label('کارمند')
                    ->relationship('employee', 'id')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\Employee $record) => (string) ((($record->first_name ?? null) ?: ($record->last_name ?? null) ?: ($record->personnel_code ?? null) ?: ($record->name ?? null)) ?: ('#' . $record->getKey())))
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('evaluator_id')
                    ->label('ارزیاب')
                    ->relationship('evaluator', 'id')
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
            'index' => Pages\ListPerformanceEvaluations::route('/'),
            'create' => Pages\CreatePerformanceEvaluation::route('/create'),
            'edit' => Pages\EditPerformanceEvaluation::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('id');
    }
}
