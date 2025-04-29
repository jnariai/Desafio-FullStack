<?php

namespace App\Data;

use Illuminate\Http\Request;

final readonly class PaginationData
{
    public function __construct(
        public int $page,
        public int $per_page,
        public ?string $sortBy = null,
        public ?OrderData $order = null

    ) {}

    public static function fromRequest(Request $request): self
    {
        $page = $request->integer('page', 1);
        $perPage = $request->integer('per_page', 10);
        $sortBy = $request->string('sort_by')->isNotEmpty() ? $request->string('sort_by') : null;
        $order = $request->string('order')->isNotEmpty() ? new OrderData($request->string('order')) : null;

        return new self(
            page: $page,
            per_page: $perPage,
            sortBy: $sortBy,
            order: $order
        );
    }
}
