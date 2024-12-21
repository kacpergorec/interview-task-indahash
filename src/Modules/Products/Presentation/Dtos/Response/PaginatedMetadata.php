<?php
declare (strict_types=1);

namespace App\Modules\Products\Presentation\Dtos\Response;

use App\Shared\Domain\Money;

class PaginatedMetadata
{
    public function __construct(
        public string $currentPage,
        public string $limit,
        public string $totalItems,
        public string $totalPages
    )
    {
    }
}