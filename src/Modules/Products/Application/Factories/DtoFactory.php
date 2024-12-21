<?php
declare (strict_types=1);

namespace App\Modules\Products\Application\Factories;

use App\Modules\Products\Application\Dtos\ProductDto;
use App\Modules\Products\Domain\ValueObjects\ProductId;
use App\Modules\Products\Presentation\Dtos\Request\CreateProductRequest;

readonly class DtoFactory
{

    public static function createFromRequest(ProductId $Id, CreateProductRequest $request) : ProductDto
    {
        return new ProductDto(
            id: $Id,
            name: $request->name,
            description: $request->description,
            grossPrice: $request->grossPrice
        );
    }

}