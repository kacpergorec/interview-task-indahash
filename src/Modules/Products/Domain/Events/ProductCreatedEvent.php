<?php
declare (strict_types=1);

namespace App\Modules\Products\Domain\Events;

use App\Modules\Products\Domain\ValueObjects\ProductId;
use App\Shared\Domain\DomainEventInterface;

readonly class ProductCreatedEvent implements DomainEventInterface
{
    public function __construct(
        public ProductId $productId
    ) {}
}