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
            'kode_penyakit' => ['required', 'string', 'max:20', Rule::unique('penyakit', 'kode_penyakit')->ignore($this->route('penyakit'))],
            'nama_penyakit' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'kode_penyakit.required' => 'Kode penyakit wajib diisi.',
            'kode_penyakit.unique' => 'Kode penyakit sudah digunakan.',
            'kode_penyakit.max' => 'Kode penyakit maksimal 20 karakter.',
            'nama_penyakit.required' => 'Nama penyakit wajib diisi.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
        ];
    }
}
