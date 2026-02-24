<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class AdmissionApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_name',
        'guardian_name',
        'email',
        'phone',
        'address',
        'applying_class',
        'previous_school',
        'documents',
        'status',
        'admin_notes',
    ];

    protected function casts(): array
    {
        return [
            'documents' => 'array',
        ];
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeByStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }
}
