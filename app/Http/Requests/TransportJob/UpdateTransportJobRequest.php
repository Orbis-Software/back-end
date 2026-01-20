<?php

namespace App\Http\Requests\TransportJob;

use App\Enums\TransportMode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateTransportJobRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $id = (int) $this->route('transport_job'); // works with apiResource('transport-jobs', ...)

        return [
            'company_id'        => ['sometimes', 'required', 'integer', 'exists:companies,id'],
            'customer_id'       => ['sometimes', 'nullable', 'integer', 'exists:contacts,id'],

            'account_number'    => ['sometimes', 'nullable', 'string', 'max:255'],
            'customer'          => ['sometimes', 'nullable', 'string', 'max:255'],
            'quote_ref'         => ['sometimes', 'nullable', 'string', 'max:255'],

            'job_number'        => ['sometimes', 'required', 'string', 'max:255', "unique:transport_jobs,job_number,{$id}"],
            'job_date'          => ['sometimes', 'nullable', 'date'],

            'mode_of_transport' => ['sometimes', 'required', new Enum(TransportMode::class)],
        ];
    }
}
