<?php

namespace App\Http\Requests;

use App\Enums\Sexo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class UpdateDesenvolvedorRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nivel_id' => ['nullable', 'exists:niveis,id'],
            'nome' => ['nullable', 'string', 'max:255'],
            'sexo' => ['nullable', 'string', Rule::enum(Sexo::class)],
            'data_nascimento' => ['nullable', 'date', 'date_format:Y-m-d'],
            'hobby' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($validator->errors()->any()) {
                    return;
                }

                $data = array_filter($this->validated());

                if (count($data) === 0) {
                    $validator->errors()->add('data', 'Nenhum dado foi enviado para atualização.');
                }
            },
        ];
    }
}
