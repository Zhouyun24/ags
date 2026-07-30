<?php

namespace App\Http\Requests\Operator;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDosenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:penggunas,email,' . $this->input('id_pengguna') . ',id_pengguna',
            'kata_sandi' => 'nullable|string|min:8',
            'nomor_telepon' => 'nullable|string|max:20',
            'program_studi' => 'required|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
            'kata_sandi.min' => 'Kata sandi minimal 8 karakter.',
            'program_studi.required' => 'Program studi wajib diisi.',
        ];
    }
}
