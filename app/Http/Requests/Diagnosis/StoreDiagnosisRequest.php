<?php

namespace App\Http\Requests\Diagnosis;

use Illuminate\Foundation\Http\FormRequest;

class StoreDiagnosisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:100'],
            'usia' => ['required', 'integer', 'min:1', 'max:255'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'gejala_ids' => ['required', 'array', 'min:1'],
            'gejala_ids.*' => ['integer', 'exists:gejala,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama pasien wajib diisi.',
            'nama.max' => 'Nama pasien maksimal 100 karakter.',
            'usia.required' => 'Usia wajib diisi.',
            'usia.integer' => 'Usia harus berupa angka.',
            'usia.min' => 'Usia minimal 1 tahun.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid.',
            'gejala_ids.required' => 'Minimal satu gejala harus dipilih.',
            'gejala_ids.min' => 'Minimal satu gejala harus dipilih.',
            'gejala_ids.*.exists' => 'Gejala tidak valid.',
        ];
    }
}
