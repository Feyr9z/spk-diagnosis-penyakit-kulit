<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama'     => ['required', 'string', 'max:100'],
            'username' => [
                'required',
                'string',
                'max:100',
                Rule::unique('users', 'username')->ignore($this->user()->id),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required'     => 'Nama wajib diisi.',
            'nama.max'          => 'Nama maksimal 100 karakter.',
            'username.required' => 'Username wajib diisi.',
            'username.max'      => 'Username maksimal 100 karakter.',
            'username.unique'   => 'Username sudah digunakan.',
        ];
    }
}
