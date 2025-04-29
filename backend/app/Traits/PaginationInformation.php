<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

trait PaginationInformation
{
    public function paginationInformation(Request $request, array $paginated, array $default): array
    {
        return [
            'meta' => [
                'total'        => Arr::get($default, 'meta.total'),
                'per_page'     => Arr::get($default, 'meta.per_page'),
                'current_page' => Arr::get($default, 'meta.current_page'),
                'last_page'    => Arr::get($default, 'meta.last_page'),
            ],
        ];
    }
}
