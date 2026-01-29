<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Core identity
            'legal_name'          => ['required', 'string', 'max:255'],
            'trading_name'        => ['nullable', 'string', 'max:255'],
            'registration_number' => ['nullable', 'string', 'max:255'],

            // Addresses
            'registered_address'  => ['nullable', 'string'],
            'operational_address' => ['nullable', 'string'],

            // Preferences
            'default_currency'    => ['nullable', 'string', 'size:3'],
            'language'            => ['nullable', 'string', 'max:5'],
            'time_zone'           => ['nullable', 'string', 'max:64'],

            // Branding (✅ file upload)
            'logo'                => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

            // Status
            'status'              => ['nullable', 'string', 'max:50'],
        ];
    }
}
