<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        // General
        'site_name',
        'tagline',
        'logo',
        'address',
        'phone_1',
        'phone_2',
        'email_1',
        'email_2',

        // Social
        'facebook_url',
        'youtube_url',
        'twitter_url',
        'instagram_url',
        'whatsapp_url',
        'linkedin_url',

        // Map
        'map_url',
        'map_embed_code',

        // Contact extras
        'office_hours',

        // About / Overview
        'established_year',
        'about_description',
        'about_quote',
        'about_image',

        // Mission & Vision
        'mission_title',
        'mission_subtitle',
        'mission_description',
        'vision_title',
        'vision_subtitle',
        'vision_description',

        // Principal
        'principal_name',
        'principal_title',
        'principal_credentials',
        'principal_experience',
        'principal_image',
        'principal_message',

        // Home page JSON sections
        'stats',
        'carousel_slides',
        'features',
        'facilities',

        // Welcome
        'welcome_title',
        'welcome_subtitle',
        'welcome_description',
        'welcome_image',
    ];

    protected $casts = [
        'principal_message' => 'array',
        'stats' => 'array',
        'carousel_slides' => 'array',
        'features' => 'array',
        'facilities' => 'array',
    ];

    /**
     * Get the singleton instance (always row id=1).
     */
    public static function instance(): self
    {
        return static::firstOrCreate(['id' => 1]);
    }
}
