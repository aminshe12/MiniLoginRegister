<?php

namespace App\Http\Requests;

use App\Support\PersianDigits;
use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'mobile' => isset($this->mobile) ? PersianDigits::toEnglish((string) $this->mobile) : null,
            'national_code' => isset($this->national_code) ? PersianDigits::toEnglish((string) $this->national_code) : null,
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
}


