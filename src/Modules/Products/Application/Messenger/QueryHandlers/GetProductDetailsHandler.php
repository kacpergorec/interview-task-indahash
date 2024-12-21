<?php
declare (strict_types=1);

namespace App\Modules\Products\Application\Messenger\QueryHandlers;

use App\Modules\Products\Application\Dtos\ProductDto;
use App\Modules\Products\Application\Exception\ProductNotFoundException;
use App\Modules\Products\Application\Factories\DtoFactory;
use App\Modules\Products\Application\Messenger\Queries\GetProductDetailsQuery;
use App\Modules\Products\Domain\Repositories\ProductQueryRepositoryInterface;

readonly class GetProductDetailsHandler //todo: unit test
{
    public function __construct(
       public ProductQueryRepositoryInterface $productQueryRepository
    )
    {
    }

    public function __invoke(GetProductDetailsQuery $query) : ProductDto
    {
        $product = $this->productQueryRepository->find($query->productId);

        if (!$product) {
            throw new ProductNotFoundException('Product not found');
        }

        return DtoFactory::createFromEntity($product);
    }

}