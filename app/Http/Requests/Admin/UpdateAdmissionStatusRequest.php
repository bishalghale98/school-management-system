<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdmissionStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'in:pending,reviewed,accepted,rejected'],
            'admin_notes' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
