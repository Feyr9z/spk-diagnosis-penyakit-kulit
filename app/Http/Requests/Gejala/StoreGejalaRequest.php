<?php

namespace App\Http\Requests\Gejala;

use Illuminate\Foundation\Http\FormRequest;

class StoreGejalaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kode'  => ['required', 'string', 'max:20', 'unique:gejala,kode'],
            'nama'  => ['required', 'string', 'max:255'],
            'bobot' => ['required', 'integer', 'min:1', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'kode.required'  => 'Kode gejala wajib diisi.',
            'kode.unique'    => 'Kode gejala sudah digunakan.',
            'kode.max'       => 'Kode gejala maksimal 20 karakter.',
            'nama.required'  => 'Nama gejala wajib diisi.',
            'bobot.required' => 'Bobot wajib diisi.',
            'bobot.integer'  => 'Bobot harus berupa angka.',
            'bobot.min'      => 'Bobot minimal 1.',
            'bobot.max'      => 'Bobot maksimal 255.',
        ];
    }
}
