<?php

namespace App\Actions;

use App\Http\Requests\NivelRequest;
use App\Models\Nivel;

final readonly class CreateNivelAction
{
    public function execute(NivelRequest $request): Nivel
    {
        return Nivel::create($request->validated());
    }
}
