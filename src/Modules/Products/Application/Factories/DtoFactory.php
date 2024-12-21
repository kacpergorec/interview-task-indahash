<?php
declare (strict_types=1);

namespace App\Modules\Products\Application\Factories;

use App\Modules\Products\Application\Dtos\ProductDto;
use App\Modules\Products\Domain\Entities\Product;
use App\Modules\Products\Domain\ValueObjects\ProductId;
use App\Modules\Products\Presentation\Dtos\Request\ProductRequestInterface;

readonly class DtoFactory
{

    public static function createFromRequest(ProductId $Id, ProductRequestInterface $request) : ProductDto
    {
        return new ProductDto(
            id: $Id,
            name: $request->name,
            description: $request->description,
            grossPrice: $request->grossPrice
        );
    }

    public static function createFromEntity(Product $product) : ProductDto
    {
        return new ProductDto(
            id: $product->getId(),
            name: $product->getName(),
            description: $product->getDescription(),
            grossPrice: $product->getGrossPrice()
        );
    }

}