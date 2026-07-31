<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApprovalWorkflow extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'approval_workflows';

    protected $fillable = [
        'name', 'slug', 'target_type', 'steps', 'is_active', 'description',
    ];

    protected function casts(): array
    {
        return [
            'steps' => 'array',
            'is_active' => 'boolean',
        ];
    }
}
