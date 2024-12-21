<?php
declare (strict_types=1);

namespace App\Modules\Products\Application\Events;


use App\Modules\Products\Domain\ValueObjects\ProductId;
use App\Shared\Domain\Money;

final readonly class ProductUpdateRequestEvent
{
    public function __construct(
        public ProductId $productId,
        public ?string $name,
        public ?string $description,
        public ?Money $grossPrice
    ) {}
}
