<?php

namespace App\Data;

use Illuminate\Http\Request;

final readonly class FilterData
{
    public function __construct(
        public PaginationData $pagination,
        public ?string $search = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        $pagination = PaginationData::fromRequest($request);

        return new self(
            pagination: $pagination,
            search: $request->string('search'),
        );
    }
}
