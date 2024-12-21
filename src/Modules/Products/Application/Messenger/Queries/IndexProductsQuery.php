<?php
declare (strict_types=1);

namespace App\Modules\Products\Application\Messenger\Queries;

use App\Shared\Enums\SortDirection;

final readonly class IndexProductsQuery
{
    public function __construct(
        public SortDirection $sortDirection = SortDirection::ASC,
        public string $sortBy = 'id',
        public int $page = 1,
        public int $limit = 10
    )
    {
    }
}