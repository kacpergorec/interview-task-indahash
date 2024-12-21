<?php
declare (strict_types=1);

namespace App\Modules\Products\Application\Dtos;

use App\Modules\Products\Domain\ValueObjects\ProductId;
use App\Shared\Domain\Money;

final readonly class ProductDto
{
    public function __construct(
        public ProductId $id,
        public string    $name,
        public string    $description,
        public Money     $grossPrice,
    )
    {
    }
}