<?php
declare (strict_types=1);

namespace App\Modules\Products\Application\Messenger\Commands;

use App\Modules\Products\Application\Dtos\ProductDto;
use Symfony\Component\Messenger\Attribute\AsMessage;

#[AsMessage]
final readonly class CreateProductCommand
{
    public function __construct(
        public ProductDto $productDto
    )
    {
    }

}