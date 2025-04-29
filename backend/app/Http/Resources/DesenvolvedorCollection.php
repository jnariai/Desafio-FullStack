<?php

namespace App\Http\Resources;

use App\Traits\PaginationInformation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\Desenvolvedor */
final class DesenvolvedorCollection extends ResourceCollection
{
    use PaginationInformation;

    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
    }
}
