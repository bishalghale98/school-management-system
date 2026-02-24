<?php

namespace App\Http\Requests\PublicSite;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_name' => ['required', 'string', 'max:255'],
            'guardian_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'applying_class' => ['required', 'string', 'max:50'],
            'previous_school' => ['nullable', 'string', 'max:255'],
            'documents' => ['nullable', 'array'],
            'documents.*' => ['file', 'max:5120'],
        ];
    }
}
