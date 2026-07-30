<?php

namespace App\Http\Requests\Operator;

use Illuminate\Foundation\Http\FormRequest;

class StoreMahasiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nim' => 'required|string|max:20|unique:mahasiswas,nim',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:penggunas,email',
            'kata_sandi' => 'required|string|min:8',
            'nomor_telepon' => 'nullable|string|max:20',
            'program_studi' => 'required|string|max:100',
            'semester' => 'required|integer|min:1|max:14',
            'nip' => 'nullable|string|exists:dosen_pas,nip',
        ];
    }

    public function messages(): array
    {
        return [
            'nim.required' => 'NIM wajib diisi.',
            'nim.unique' => 'NIM sudah terdaftar.',
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'kata_sandi.required' => 'Kata sandi wajib diisi.',
            'kata_sandi.min' => 'Kata sandi minimal 8 karakter.',
            'program_studi.required' => 'Program studi wajib diisi.',
            'semester.required' => 'Semester wajib diisi.',
            'semester.integer' => 'Semester harus berupa angka.',
            'nip.exists' => 'Dosen PA yang dipilih tidak valid.',
        ];
    }
}
