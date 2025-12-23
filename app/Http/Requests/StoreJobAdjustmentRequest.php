<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobAdjustmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'amount_delta' => ['required', 'numeric'],
            'currency' => ['required', 'string', 'size:3'],
        ];
    }
}
