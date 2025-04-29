<?php

namespace App\Actions;

use App\Http\Requests\NivelRequest;
use App\Models\Nivel;
use Exception;

final readonly class UpdateNivelAction
{
    public function execute(NivelRequest $request, Nivel $nivel): Nivel
    {
        $nivel->update($request->validated());

        if (! $nivel->wasChanged()) {
            throw new Exception('Erro ao atualizar nível');
        }

        $nivel->refresh();

        return $nivel;
    }
}
