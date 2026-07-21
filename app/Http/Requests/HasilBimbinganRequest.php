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
            'catatan_bimbingan' => ['required', 'string'],
            'arahan_akademik' => ['required', 'string'],
        ];
    }
}
