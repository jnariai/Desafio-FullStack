<?php

namespace App\Actions;

use App\Models\Desenvolvedor;

final readonly class DeleteDesenvolvedorAction
{
    public function execute(Desenvolvedor $desenvolvedor): bool
    {
        return $desenvolvedor->delete();
    }
}
