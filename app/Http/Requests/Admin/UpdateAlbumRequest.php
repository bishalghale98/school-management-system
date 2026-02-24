<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAlbumRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('gallery_albums', 'slug')->ignore($this->route('album'))],
            'description' => ['nullable', 'string', 'max:1000'],
            'cover_image' => ['nullable', 'image', 'max:2048'],
            'event_date' => ['nullable', 'date'],
            'status' => ['required', 'in:draft,published'],
            'published_at' => ['nullable', 'date'],
        ];
    }
}
