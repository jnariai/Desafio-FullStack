<?php

namespace App\Http\Requests;

use App\Enums\Sexo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreDesenvolvedorRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nivel_id'        => ['required', 'exists:niveis,id'],
            'nome'            => ['required', 'string', 'max:255'],
            'sexo'            => ['required', 'string', Rule::enum(Sexo::class)],
            'data_nascimento' => ['required', 'date', 'date_format:Y-m-d'],
            'hobby'           => ['required', 'string', 'max:255'],
        ];
    }
}
