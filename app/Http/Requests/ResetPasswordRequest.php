<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kata_sandi_lama' => 'required|string',
            'kata_sandi_baru' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'kata_sandi_lama.required' => 'Kata sandi lama wajib diisi.',
            'kata_sandi_baru.required' => 'Kata sandi baru wajib diisi.',
            'kata_sandi_baru.min' => 'Kata sandi baru minimal 8 karakter.',
            'kata_sandi_baru.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ];
    }
}
