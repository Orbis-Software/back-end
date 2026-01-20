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
            // If you want true multi-tenant safety, DO NOT accept company_id from request.
            // Instead set it in controller/service from auth()->user()->company_id.
            // 'company_id' => ['required', 'integer', 'exists:companies,id'],

            'contact_type'        => ['required', new Enum(ContactType::class)],
            'address'             => ['nullable', 'string', 'max:255'],
            'country'             => ['nullable', 'string', 'size:2'],
            'eori'                => ['nullable', 'string', 'max:255'],
            'credit_limit'        => ['nullable', 'numeric', 'min:0'],
            'currency_preference' => ['nullable', 'string', 'size:3'],
            'status'              => ['nullable', 'string', 'max:50'],
        ];
    }
}
