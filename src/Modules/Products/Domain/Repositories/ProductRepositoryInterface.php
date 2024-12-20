<?php
declare (strict_types=1);

namespace App\Modules\Products\Domain\Repositories;


use App\Modules\Products\Domain\Entities\Product;

interface ProductRepositoryInterface
{
    public function save(Product $product): void;

    public function delete(Product $product): void;
}