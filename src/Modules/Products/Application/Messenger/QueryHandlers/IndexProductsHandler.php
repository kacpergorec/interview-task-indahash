<?php
declare (strict_types=1);

namespace App\Modules\Products\Application\Messenger\QueryHandlers;

use App\Modules\Products\Application\Factories\DtoFactory;
use App\Modules\Products\Application\Messenger\Queries\IndexProductsQuery;
use App\Modules\Products\Domain\Entities\Product;
use App\Modules\Products\Domain\Repositories\ProductQueryRepositoryInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

readonly class IndexProductsHandler //todo: unit test
{
    public function __construct(
        public ProductQueryRepositoryInterface $productQueryRepository,
        public PaginatorInterface              $paginator
    )
    {
    }

    public function __invoke(IndexProductsQuery $query): PaginationInterface
    {
        $pagination =  $this->paginator->paginate(
            $this->productQueryRepository->prepareSortedQuery(
                sortDirection: $query->sortDirection,
                sortBy: $query->sortBy,
            ),
            $query->page,
            $query->limit
        );

        $Dtos = array_map(fn(Product $p) => DtoFactory::createFromEntity($p), $pagination->getItems());
        $pagination->setItems($Dtos);

        return $pagination;
    }

}