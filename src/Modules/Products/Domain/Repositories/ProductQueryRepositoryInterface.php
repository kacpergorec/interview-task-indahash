<?php
declare (strict_types=1);

namespace App\Modules\Products\Domain\Repositories;

use App\Modules\Products\Domain\Entities\Product;

interface ProductQueryRepositoryInterface
{
    /** @return Product[] */
    public function findAll() : array;
}