<?php

namespace App\Http\Requests\Contact;

use App\Enums\ContactType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'contact_types'   => ['required', 'array', 'min:1'],
            'contact_types.*' => ['required', 'distinct', new Enum(ContactType::class)],

            'address'             => ['nullable', 'string', 'max:255'],
            'country'             => ['nullable', 'string', 'size:2'],
            'eori'                => ['nullable', 'string', 'max:255'],
            'credit_limit'        => ['nullable', 'numeric', 'min:0'],
            'currency_preference' => ['nullable', 'string', 'size:3'],
            'status'              => ['nullable', 'string', 'max:50'],
        ];
    }
}
