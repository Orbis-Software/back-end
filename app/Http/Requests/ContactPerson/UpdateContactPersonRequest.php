<?php

namespace App\Http\Requests\ContactPerson;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactPersonRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'contact_id' => ['sometimes', 'required', 'integer', 'exists:contacts,id'],
            'name'       => ['sometimes', 'required', 'string', 'max:255'],
            'email'      => ['sometimes', 'nullable', 'email', 'max:255'],
            'phone'      => ['sometimes', 'nullable', 'string', 'max:50'],
        ];
    }
}
