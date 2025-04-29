<?php

namespace App\Actions;

use App\Http\Requests\StoreDesenvolvedorRequest;
use App\Models\Desenvolvedor;

final readonly class CreateDesenvolvedorAction
{
    public function execute(StoreDesenvolvedorRequest $request): Desenvolvedor
    {
        return Desenvolvedor::create($request->validated());
    }
}
