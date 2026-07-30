<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'employee_id', 'evaluation_period', 'evaluation_type', 'evaluator_id',
    'self_score', 'supervisor_score', 'peer_score', 'overall_score', 'job_knowledge',
    'quality_of_work', 'quantity_of_work', 'punctuality', 'teamwork', 'initiative',
    'strengths', 'improvement_areas', 'development_goals', 'training_recommendations',
    'promotion_recommendation', 'comments', 'status', 'created_by', 'updated_by',
])]
class PerformanceEvaluation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'performance_evaluations';

    protected function casts(): array
    {
        return [
            'self_score' => 'decimal:2',
            'supervisor_score' => 'decimal:2',
            'peer_score' => 'decimal:2',
            'overall_score' => 'decimal:2',
            'job_knowledge' => 'decimal:2',
            'quality_of_work' => 'decimal:2',
            'quantity_of_work' => 'decimal:2',
            'punctuality' => 'decimal:2',
            'teamwork' => 'decimal:2',
            'initiative' => 'decimal:2',
            'promotion_recommendation' => 'boolean',
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function evaluator(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'evaluator_id');
    }
}
