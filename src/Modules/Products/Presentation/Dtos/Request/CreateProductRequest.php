<?php
declare (strict_types=1);

namespace App\Modules\Products\Presentation\Dtos\Request;

use App\Shared\Domain\Money;

readonly final class CreateProductRequest
{
    public function __construct(
        public string $name,
        public string $description,
        public Money $grossPrice,
    )
    {
    }
}