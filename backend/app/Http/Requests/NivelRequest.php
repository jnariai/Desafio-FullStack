<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class NivelRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nivel' => ['required', 'string', 'max:255', Rule::unique('niveis')->ignore($this->route('nivel'))],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('nivel')) {
            $this->merge([
                'nivel' => Str::title($this->nivel),
            ]);
        }
    }
}
