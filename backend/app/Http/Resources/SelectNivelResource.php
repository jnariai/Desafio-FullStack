<?php

namespace App\Http\Resources;

use App\Models\Nivel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Nivel */
final class SelectNivelResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'nivel' => $this->nivel,
        ];
    }
}
