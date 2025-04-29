<?php

namespace App\Data;

use InvalidArgumentException;

final readonly class OrderData
{
    public function __construct(public string $value)
    {
        if (! in_array($value, ['asc', 'desc'])) {
            throw new InvalidArgumentException('Valor inválido para order. Aceito apenas "asc" ou "desc".');
        }
    }
}
