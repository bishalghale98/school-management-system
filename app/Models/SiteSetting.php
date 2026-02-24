<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'tagline',
        'logo',
        'address',
        'phone_1',
        'phone_2',
        'email_1',
        'email_2',
        'facebook_url',
        'youtube_url',
        'twitter_url',
        'instagram_url',
        'map_url',
        'map_embed_code',
    ];

    /**
     * Get the singleton instance (always row id=1).
     */
    public static function instance(): self
    {
        return static::firstOrCreate(['id' => 1]);
    }
}
