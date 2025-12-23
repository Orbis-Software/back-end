<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobRevenueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description' => ['sometimes', 'string', 'max:255'],
            'amount' => ['sometimes', 'numeric'],
            'currency' => ['sometimes', 'string', 'size:3'],
        ];
    }
}
