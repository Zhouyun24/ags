<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HasilBimbinganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'topik_diskusi' => ['required', 'string', 'max:64'],
            'catatan_bimbingan' => ['required', 'string', 'max:255'],
            'arahan_akademik' => ['required', 'string', 'max:255'],
        ];
    }
}
