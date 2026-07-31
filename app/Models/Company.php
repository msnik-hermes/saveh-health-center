<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'companies';

    protected $fillable = [
        'name', 'registration_number', 'national_id', 'phone', 'email',
        'address', 'city', 'province', 'contact_person', 'contact_phone',
        'status', 'notes',
    ];

    protected function casts(): array
    {
        return [];
    }

    public function companyInspections(): HasMany
    {
        return $this->hasMany(CompanyInspection::class);
    }

    public function hazardAssessments(): HasMany
    {
        return $this->hasMany(HazardAssessment::class);
    }
}
