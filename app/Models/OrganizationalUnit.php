<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationalUnit extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'organizational_units';

    protected $fillable = [
        'center_id', 'parent_id', 'code', 'name', 'name_en',
        'head_employee_id', 'phone', 'budget_allocation',
        'description', 'status', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'budget_allocation' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function head(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'head_employee_id');
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'unit_id');
    }
}
