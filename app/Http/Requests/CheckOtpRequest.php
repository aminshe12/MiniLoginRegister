<?php

namespace App\Http\Requests;

use App\Support\PersianDigits;
use Illuminate\Foundation\Http\FormRequest;

class CheckOtpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'mobile' => isset($this->mobile) ? PersianDigits::toEnglish((string) $this->mobile) : null,
            'otp' => isset($this->otp) ? PersianDigits::toEnglish((string) $this->otp) : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'mobile' => ['required', 'regex:/^09\d{9}$/'],
            'otp' => ['required', 'digits:6'],
        ];
    }
}


