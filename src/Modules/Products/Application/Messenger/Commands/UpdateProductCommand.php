<?php
declare (strict_types=1);

namespace App\Modules\Products\Application\Messenger\Commands;

use App\Modules\Products\Application\Dtos\ProductDto;
use App\Modules\Products\Domain\ValueObjects\ProductId;
use App\Shared\Domain\Money;
use Symfony\Component\Messenger\Attribute\AsMessage;

#[AsMessage]
final readonly class UpdateProductCommand
{
    public function __construct(
        public ProductId $productId,
        public ?string $name,
        public ?string $description,
        public ?Money $grossPrice
    )
    {
    }

}