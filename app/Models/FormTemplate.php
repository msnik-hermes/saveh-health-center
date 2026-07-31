<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'name', 'slug', 'category', 'description', 'fields_schema', 'target_roles',
    'target_center_types', 'version', 'is_active', 'created_by', 'updated_by',
])]
class FormTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'form_templates';

    protected function casts(): array
    {
        return [
            'fields_schema' => 'array',
            'target_roles' => 'array',
            'target_center_types' => 'array',
            'version' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(FormSubmission::class);
    }
}
