<?php

namespace App\Http\Requests\Penyakit;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePenyakitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kode'     => ['required', 'string', 'max:20', Rule::unique('penyakit', 'kode')->ignore($this->route('penyakit'))],
            'nama'     => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'solusi'   => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'kode.required'      => 'Kode penyakit wajib diisi.',
            'kode.unique'        => 'Kode penyakit sudah digunakan.',
            'kode.max'           => 'Kode penyakit maksimal 20 karakter.',
            'nama.required'      => 'Nama penyakit wajib diisi.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'solusi.required'    => 'Solusi wajib diisi.',
        ];
    }
}
