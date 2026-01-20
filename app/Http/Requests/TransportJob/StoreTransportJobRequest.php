<?php

namespace App\Http\Requests\TransportJob;

use App\Enums\TransportMode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreTransportJobRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'company_id'        => ['required', 'integer', 'exists:companies,id'],
            'customer_id'       => ['nullable', 'integer', 'exists:contacts,id'],

            'account_number'    => ['nullable', 'string', 'max:255'],
            'customer'          => ['nullable', 'string', 'max:255'],
            'quote_ref'         => ['nullable', 'string', 'max:255'],

            'job_number'        => ['required', 'string', 'max:255', 'unique:transport_jobs,job_number'],
            'job_date'          => ['nullable', 'date'],

            'mode_of_transport' => ['required', new Enum(TransportMode::class)],
        ];
    }
}
