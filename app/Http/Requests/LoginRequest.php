<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Allow unauthenticated users to access login.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for login.
     */
    public function rules(): array
    {
        // $emailRule = app()->environment('production')
        //     ? 'email:rfc,dns'
        //     : 'email:rfc';

        return [
            // 'email'    => ['required', $emailRule],
            'email' => ['required', 'email'],
            'password' => ['required', 'string'], // login doesn't need min length (policy belongs to register/reset)
        ];
    }

    /**
     * Custom error messages (API-friendly).
     */
    public function messages(): array
    {
        return [
            'email.required'    => 'Email is required.',
            'email.email'       => 'Email must be a valid email address.',
            'password.required' => 'Password is required.',
        ];
    }

    /**
     * Normalize input before validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('email')) {
            $this->merge([
                'email' => strtolower(trim((string) $this->email)),
            ]);
        }
    }
}
