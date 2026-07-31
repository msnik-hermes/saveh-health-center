<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DigitalCertificate extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'digital_certificates';

    protected $fillable = [
        'name', 'certificate_type', 'certificate_data', 'private_key',
        'issued_at', 'expires_at', 'issued_to', 'center_id', 'status', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'issued_at' => 'date',
            'expires_at' => 'date',
        ];
    }
}
