<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'legal_name'           => ['sometimes', 'required', 'string', 'max:255'],
            'trading_name'         => ['sometimes', 'nullable', 'string', 'max:255'],
            'registration_number'  => ['sometimes', 'nullable', 'string', 'max:255'],
            'registered_address'   => ['sometimes', 'nullable', 'string', 'max:255'],
            'operational_address'  => ['sometimes', 'nullable', 'string', 'max:255'],
            'default_currency'     => ['sometimes', 'nullable', 'string', 'size:3'],
            'time_zone'            => ['sometimes', 'nullable', 'string', 'max:64'],
            'status'               => ['sometimes', 'nullable', 'string', 'max:50'],
        ];
    }
}
