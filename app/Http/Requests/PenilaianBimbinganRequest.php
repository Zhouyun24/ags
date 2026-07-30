<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenilaianBimbinganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'skor_keaktifan' => 'required|integer|min:1|max:5',
            'skor_pemahaman' => 'required|integer|min:1|max:5',
        ];
    }

    public function messages(): array
    {
        return [
            'skor_keaktifan.required' => 'Skor keaktifan wajib diisi.',
            'skor_keaktifan.integer' => 'Skor keaktifan harus berupa angka.',
            'skor_keaktifan.min' => 'Skor keaktifan minimal 1.',
            'skor_keaktifan.max' => 'Skor keaktifan maksimal 5.',
            'skor_pemahaman.required' => 'Skor pemahaman wajib diisi.',
            'skor_pemahaman.integer' => 'Skor pemahaman harus berupa angka.',
            'skor_pemahaman.min' => 'Skor pemahaman minimal 1.',
            'skor_pemahaman.max' => 'Skor pemahaman maksimal 5.',
        ];
    }
}
