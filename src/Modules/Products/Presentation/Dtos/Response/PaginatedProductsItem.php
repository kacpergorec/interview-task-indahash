<?php
declare (strict_types=1);

namespace App\Modules\Products\Presentation\Dtos\Response;

use App\Modules\Products\Application\Dtos\ProductDto;
use App\Shared\Domain\Money;

class PaginatedProductsItem
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description,
        public Money $grossPrice
    )
    {
    }

    public static function fromDto(ProductDto $item) : self
    {
        return new self(
            id: $item->id->toUuid()->toString(),
            name: $item->name,
            description: $item->description,
            grossPrice: $item->grossPrice
        );
    }
}