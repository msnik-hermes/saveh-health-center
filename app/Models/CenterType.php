<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CenterType extends Model
{
    protected $table = 'center_types';

    protected $fillable = [
        'name',
        'description',
        'capacity',
        'is_active',
    ];

    public function centers(): BelongsToMany
    {
        return $this->belongsToMany(Center::class, 'center_center_type');
    }
}
