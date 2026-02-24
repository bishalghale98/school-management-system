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
            'site_name' => ['required', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'address' => ['nullable', 'string', 'max:500'],
            'phone_1' => ['nullable', 'string', 'max:20'],
            'phone_2' => ['nullable', 'string', 'max:20'],
            'email_1' => ['nullable', 'email', 'max:255'],
            'email_2' => ['nullable', 'email', 'max:255'],
            'facebook_url' => ['nullable', 'url', 'max:500'],
            'youtube_url' => ['nullable', 'url', 'max:500'],
            'twitter_url' => ['nullable', 'url', 'max:500'],
            'instagram_url' => ['nullable', 'url', 'max:500'],
            'map_url' => ['nullable', 'url', 'max:500'],
            'map_embed_code' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
