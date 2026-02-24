<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDownloadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'category_id' => ['required', 'exists:download_categories,id'],
            'type' => ['required', 'in:file,link'],
            'file' => ['nullable', 'file', 'max:10240'],
            'external_url' => ['required_if:type,link', 'nullable', 'url', 'max:500'],
            'is_featured' => ['nullable', 'boolean'],
            'status' => ['required', 'in:draft,published'],
            'published_at' => ['nullable', 'date'],
        ];
    }
}
