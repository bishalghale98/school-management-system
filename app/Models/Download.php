<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Download extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'file_path',
        'external_url',
        'type',
        'is_featured',
        'status',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'is_featured' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(DownloadCategory::class, 'category_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
                     ->where(function ($q) {
                         $q->whereNull('published_at')
                           ->orWhere('published_at', '<=', now());
                     });
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function getDownloadUrlAttribute(): ?string
    {
        if ($this->type === 'link') {
            return $this->external_url;
        }

        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }
}
