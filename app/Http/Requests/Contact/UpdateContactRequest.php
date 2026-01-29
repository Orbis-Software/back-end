<?php

namespace App\Http\Requests\Contact;

use App\Enums\ContactType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'contact_types'   => ['sometimes', 'array', 'min:1'],
            'contact_types.*' => ['required', 'distinct', new Enum(ContactType::class)],

            'address'             => ['sometimes', 'nullable', 'string', 'max:255'],
            'country'             => ['sometimes', 'nullable', 'string', 'size:2'],
            'eori'                => ['sometimes', 'nullable', 'string', 'max:255'],
            'credit_limit'        => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'currency_preference' => ['sometimes', 'nullable', 'string', 'size:3'],
            'status'              => ['sometimes', 'nullable', 'string', 'max:50'],
        ];
    }
}
