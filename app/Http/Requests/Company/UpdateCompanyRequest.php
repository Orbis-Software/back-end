<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'legal_name'          => ['sometimes', 'required', 'string', 'max:255'],
            'trading_name'        => ['sometimes', 'nullable', 'string', 'max:255'],
            'registration_number' => ['sometimes', 'nullable', 'string', 'max:255'],

            'registered_address'  => ['sometimes', 'nullable', 'string'],
            'operational_address' => ['sometimes', 'nullable', 'string'],

            'default_currency'    => ['sometimes', 'nullable', 'string', 'size:3'],
            'language'            => ['sometimes', 'nullable', 'string', 'max:5'],
            'time_zone'           => ['sometimes', 'nullable', 'string', 'max:64'],

            // ✅ FIX
            'logo'                => ['sometimes', 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

            'status'              => ['sometimes', 'nullable', 'string', 'max:50'],
        ];
    }
}
