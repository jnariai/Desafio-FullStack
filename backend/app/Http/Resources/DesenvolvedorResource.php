<?php

namespace App\Http\Resources;

use App\Models\Desenvolvedor;
use App\Models\Nivel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Desenvolvedor */
class DesenvolvedorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $nivel = $this->nivel instanceof Nivel
            ? $this->nivel->nivel
            : $this->nivel;
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'sexo' => $this->sexo,
            'data_nascimento' => $this->data_nascimento->format('d/m/Y'),
            'idade' => $this->idade(),
            'hobby' => $this->hobby,
            'nivel' => [
                'id' => $this->nivel_id,
                'nome' => $nivel
            ],
        ];
    }
}
