<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class RegisterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'mobile' => isset($this->mobile) ? toEnglish((string) $this->mobile) : null,
            'national_code' => isset($this->national_code) ? toEnglish((string) $this->national_code) : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'mobile' => ['required', 'regex:/^09\d{9}$/'],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'national_code' => ['required', 'digits:10'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }

    public function registrationPayload(): array
    {
        return [
            'first_name' => (string) $this->get('first_name'),
            'last_name' => (string) $this->get('last_name'),
            'mobile' => (string) $this->get('mobile'),
            'national_code' => (string) $this->get('national_code'),
            'password' => Hash::make((string) $this->get('password')),
        ];
    }
}


