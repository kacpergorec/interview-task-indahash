<?php
declare (strict_types=1);

namespace App\Modules\Products\Application\Events;

use App\Modules\Products\Application\Dtos\ProductDto;
use App\Modules\Products\Domain\ValueObjects\ProductId;

class ProductDeletionRequestEvent
{
    public function __construct(
        public ProductId $productId
    ) {}
}
