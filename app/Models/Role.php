<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'roles';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'hierarchy_level',
        'is_system',
    ];

    protected $casts = [
        'is_system' => 'boolean',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_roles')
            ->withPivot(['unit_id', 'center_id', 'start_date', 'end_date', 'is_active'])
            ->withTimestamps();
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions')
            ->withPivot('is_granted')
            ->withTimestamps();
    }

    public function accessLevels(): BelongsToMany
    {
        return $this->belongsToMany(AccessLevel::class, 'manager_access_levels')
            ->withPivot(['can_approve', 'can_escalate', 'can_override'])
            ->withTimestamps();
    }
}