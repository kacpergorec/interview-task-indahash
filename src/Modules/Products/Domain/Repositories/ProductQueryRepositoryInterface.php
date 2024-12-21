<?php
declare (strict_types=1);

namespace App\Modules\Products\Domain\Repositories;

use App\Modules\Products\Domain\Entities\Product;
use App\Shared\Enums\SortDirection;
use Doctrine\ORM\Query;

interface ProductQueryRepositoryInterface
{
    /** @return Product[] */
    public function findAll() : array;

    public function prepareSortedQuery(SortDirection $sortDirection, string $sortBy) : Query;
}