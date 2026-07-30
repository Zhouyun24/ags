<?php

namespace App\Http\Requests\Operator;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOperatorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $idPengguna = $this->route('id_pengguna');

        return [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:penggunas,email,' . $idPengguna . ',id_pengguna',
            'kata_sandi' => 'nullable|string|min:8',
            'nomor_telepon' => 'nullable|string|max:20',
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
        ];
    }
}
