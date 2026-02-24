<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GalleryAlbum extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'cover_image',
        'event_date',
        'status',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'published_at' => 'datetime',
        ];
    }

    public function photos(): HasMany
    {
        return $this->hasMany(GalleryPhoto::class, 'album_id')->orderBy('sort_order');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }

    public function getPhotosCountAttribute(): int
    {
        return $this->photos()->count();
    }
}
