<?php
declare (strict_types=1);

namespace App\Modules\Products\Presentation\Dtos\Request;

use App\Shared\Enums\SortDirection;

class IndexProductsRequest
{
    public function __construct(
        public SortDirection $sortDirection = SortDirection::ASC,
        public string $sortBy = 'name',
        public int $page = 1,
        public int $limit = 10
    )
    {
    }
}