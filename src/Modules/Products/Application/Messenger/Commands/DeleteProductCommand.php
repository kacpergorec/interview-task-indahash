<?php
declare (strict_types=1);

namespace App\Modules\Products\Application\Messenger\Commands;

use App\Modules\Products\Application\Dtos\ProductDto;
use App\Modules\Products\Domain\ValueObjects\ProductId;
use Symfony\Component\Messenger\Attribute\AsMessage;

#[AsMessage]
final readonly class DeleteProductCommand
{
    public function __construct(
        public ProductId $productId
    )
    {
    }

}