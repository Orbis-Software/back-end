<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'legal_name'           => ['required', 'string', 'max:255'],
            'trading_name'         => ['nullable', 'string', 'max:255'],
            'registration_number'  => ['nullable', 'string', 'max:255'],
            'registered_address'   => ['nullable', 'string', 'max:255'],
            'operational_address'  => ['nullable', 'string', 'max:255'],
            'default_currency'     => ['nullable', 'string', 'size:3'],
            'time_zone'            => ['nullable', 'string', 'max:64'],
            'status'               => ['nullable', 'string', 'max:50'],
        ];
    }
}
