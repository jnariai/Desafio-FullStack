<?php

namespace App\Actions;

use App\Http\Requests\UpdateDesenvolvedorRequest;
use App\Models\Desenvolvedor;
use Exception;

final readonly class UpdateDesenvolvedorAction
{
    public function execute(UpdateDesenvolvedorRequest $request, Desenvolvedor $desenvolvedor): Desenvolvedor
    {
        $desenvolvedor->update($request->validated());

        if (! $desenvolvedor->wasChanged()) {
            throw new Exception('Erro ao atualizar desenvolvedor');
        }

        $desenvolvedor->refresh();

        return $desenvolvedor;
    }
}
