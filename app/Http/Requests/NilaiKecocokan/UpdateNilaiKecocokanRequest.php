<?php

namespace App\Http\Requests\NilaiKecocokan;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateNilaiKecocokanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'penyakit_id' => [
                'required',
                'integer',
                'exists:penyakit,id',
                Rule::unique('nilai_kecocokan')->where(function ($query) {
                    return $query->where('gejala_id', $this->gejala_id);
                })->ignore($this->route('nilai_kecocokan')),
            ],
            'gejala_id' => ['required', 'integer', 'exists:gejala,id'],
            'nilai' => ['required', 'integer', 'min:0', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'penyakit_id.required' => 'Penyakit wajib dipilih.',
            'penyakit_id.exists' => 'Penyakit tidak ditemukan.',
            'penyakit_id.unique' => 'Kombinasi penyakit dan gejala sudah ada.',
            'gejala_id.required' => 'Gejala wajib dipilih.',
            'gejala_id.exists' => 'Gejala tidak ditemukan.',
            'nilai.required' => 'Nilai wajib diisi.',
            'nilai.integer' => 'Nilai harus berupa angka.',
            'nilai.min' => 'Nilai minimal 0.',
            'nilai.max' => 'Nilai maksimal 255.',
        ];
    }
}
