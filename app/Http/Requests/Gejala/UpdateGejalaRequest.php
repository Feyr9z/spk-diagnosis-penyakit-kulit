<?php

namespace App\Http\Requests\Gejala;

use App\Models\Gejala;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGejalaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kode_gejala' => ['required', 'string', 'max:20', Rule::unique('gejala', 'kode_gejala')->ignore($this->route('gejala'))],
            'nama_gejala' => ['required', 'string', 'max:255'],
            'jenis' => ['required', 'in:benefit,cost'],
            'bobot' => [
                'required',
                'integer',
                'min:1',
                'max:100',
                function ($attribute, $value, $fail) {
                    // Exclude current record bobot
                    $currentGejalaId = $this->route('gejala')->id ?? $this->route('gejala');

                    $totalOtherBobot = Gejala::where('id', '!=', $currentGejalaId)->sum('bobot');
                    $totalBobot = $totalOtherBobot + $value;

                    if ($totalBobot > 100) {
                        $fail("Total bobot keseluruhan tidak boleh melebihi 100. (Total saat ini + input = {$totalBobot})");
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'kode_gejala.required' => 'Kode gejala wajib diisi.',
            'kode_gejala.unique' => 'Kode gejala sudah digunakan.',
            'kode_gejala.max' => 'Kode gejala maksimal 20 karakter.',
            'nama_gejala.required' => 'Nama gejala wajib diisi.',
            'jenis.required' => 'Jenis gejala wajib dipilih.',
            'jenis.in' => 'Jenis gejala harus benefit atau cost.',
            'bobot.required' => 'Bobot wajib diisi.',
            'bobot.integer' => 'Bobot harus berupa angka.',
            'bobot.min' => 'Bobot minimal 1.',
            'bobot.max' => 'Bobot maksimal 100.',
        ];
    }
}
