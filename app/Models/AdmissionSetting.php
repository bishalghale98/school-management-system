<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_open',
        'content',
        'requirements',
    ];

    protected function casts(): array
    {
        return [
            'is_open' => 'boolean',
            'requirements' => 'array',
        ];
    }

    /**
     * Get the singleton instance (always row id=1).
     */
    public static function instance(): self
    {
        return static::firstOrCreate(['id' => 1]);
    }
}
