<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AjukanJadwalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'topik' => ['required', 'string', 'max:64'],
            'tanggal' => ['required', 'date_format:Y-m-d'],
            'waktu' => ['required', 'date_format:H:i'],
        ];
    }

    public function messages(): array
    {
        return [
            'topik.required' => 'Topik bimbingan wajib diisi.',
            'topik.max' => 'Topik bimbingan maksimal 64 karakter.',
            'tanggal.required' => 'Tanggal bimbingan wajib diisi.',
            'tanggal.date_format' => 'Format tanggal tidak valid.',
            'waktu.required' => 'Waktu bimbingan wajib dipilih.',
            'waktu.date_format' => 'Format waktu tidak valid.',
        ];
    }
}
