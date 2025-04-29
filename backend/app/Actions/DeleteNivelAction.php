<?php

namespace App\Actions;

use App\Models\Nivel;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

final readonly class DeleteNivelAction
{
    public function execute(Nivel $nivel): bool
    {
        if ($nivel->desenvolvedores()->exists()) {
            throw new UnprocessableEntityHttpException('Não é possível excluir o nível, pois ele está associado a desenvolvedores.');
        }

        return $nivel->delete();
    }
}
