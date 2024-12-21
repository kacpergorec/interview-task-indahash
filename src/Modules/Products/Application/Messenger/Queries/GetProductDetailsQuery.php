<?php
declare (strict_types=1);

namespace App\Modules\Products\Application\Messenger\Queries;

use App\Modules\Products\Domain\ValueObjects\ProductId;

final readonly class GetProductDetailsQuery
{
    public function __construct(
        public ProductId $productId
    )
    {
    }
}