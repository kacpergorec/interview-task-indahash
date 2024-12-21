<?php
declare (strict_types=1);

namespace App\Modules\Products\Application\Events;


use App\Modules\Products\Application\Dtos\ProductDto;

class ProductCreationRequestEvent
{
    public function __construct(
        public ProductDto $productDto
    ) {}
}
