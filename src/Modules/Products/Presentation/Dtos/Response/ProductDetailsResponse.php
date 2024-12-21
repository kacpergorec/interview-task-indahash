<?php
declare (strict_types=1);

namespace App\Modules\Products\Presentation\Dtos\Response;

use App\Shared\Domain\Money;

class ProductDetailsResponse
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description,
        public Money $grossPrice,
    )
    {
    }
}