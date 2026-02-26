<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            // General
            'site_name' => ['required', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'],

            // Contact
            'address' => ['nullable', 'string', 'max:500'],
            'phone_1' => ['nullable', 'string', 'max:20'],
            'phone_2' => ['nullable', 'string', 'max:20'],
            'email_1' => ['nullable', 'email', 'max:255'],
            'email_2' => ['nullable', 'email', 'max:255'],
            'office_hours' => ['nullable', 'string', 'max:255'],

            // Social
            'facebook_url' => ['nullable', 'url', 'max:500'],
            'youtube_url' => ['nullable', 'url', 'max:500'],
            'twitter_url' => ['nullable', 'url', 'max:500'],
            'instagram_url' => ['nullable', 'url', 'max:500'],
            'whatsapp_url' => ['nullable', 'url', 'max:500'],
            'linkedin_url' => ['nullable', 'url', 'max:500'],

            // Map
            'map_url' => ['nullable', 'url', 'max:500'],
            'map_embed_code' => ['nullable', 'string', 'max:2000'],

            // About / Overview
            'established_year' => ['nullable', 'string', 'max:50'],
            'about_description' => ['nullable', 'string', 'max:5000'],
            'about_quote' => ['nullable', 'string', 'max:1000'],
            'about_image' => ['nullable', 'image', 'max:2048'],

            // Mission & Vision
            'mission_title' => ['nullable', 'string', 'max:255'],
            'mission_subtitle' => ['nullable', 'string', 'max:255'],
            'mission_description' => ['nullable', 'string', 'max:5000'],
            'vision_title' => ['nullable', 'string', 'max:255'],
            'vision_subtitle' => ['nullable', 'string', 'max:255'],
            'vision_description' => ['nullable', 'string', 'max:5000'],

            // Principal
            'principal_name' => ['nullable', 'string', 'max:255'],
            'principal_title' => ['nullable', 'string', 'max:255'],
            'principal_credentials' => ['nullable', 'string', 'max:255'],
            'principal_experience' => ['nullable', 'string', 'max:255'],
            'principal_image' => ['nullable', 'image', 'max:2048'],
            'principal_message' => ['nullable', 'array'],
            'principal_message.*' => ['string', 'max:5000'],

            // Stats
            'stats' => ['nullable', 'array'],
            'stats.*.value' => ['required_with:stats', 'string', 'max:50'],
            'stats.*.label' => ['required_with:stats', 'string', 'max:100'],

            // Carousel slides
            'carousel_slides' => ['nullable', 'array'],
            'carousel_slides.*.image' => ['required_with:carousel_slides'],
            'carousel_slides.*.title' => ['required_with:carousel_slides', 'string', 'max:255'],
            'carousel_slides.*.description' => ['nullable', 'string', 'max:500'],

            // Features
            'features' => ['nullable', 'array'],
            'features.*.title' => ['required_with:features', 'string', 'max:255'],
            'features.*.description' => ['required_with:features', 'string', 'max:1000'],
            'features.*.image' => ['required_with:features', 'string', 'max:500'],
            'features.*.badge' => ['nullable', 'string', 'max:100'],
            'features.*.metric' => ['nullable', 'string', 'max:100'],
            'features.*.stats' => ['nullable', 'string', 'max:100'],

            // Facilities
            'facilities' => ['nullable', 'array'],
            'facilities.*.title' => ['required_with:facilities', 'string', 'max:255'],
            'facilities.*.description' => ['required_with:facilities', 'string', 'max:1000'],
            'facilities.*.image' => ['nullable', 'string', 'max:500'],

            // Welcome
            'welcome_title' => ['nullable', 'string', 'max:255'],
            'welcome_subtitle' => ['nullable', 'string', 'max:255'],
            'welcome_description' => ['nullable', 'string', 'max:5000'],
            'welcome_image' => ['nullable', 'image', 'max:2048'],
        ];
    }
}
