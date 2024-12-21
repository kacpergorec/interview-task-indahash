<?php
declare (strict_types=1);

namespace App\Modules\Products\Presentation\Dtos\Response;

use App\Modules\Products\Application\Dtos\ProductDto;
use Knp\Component\Pager\Pagination\PaginationInterface;

class PaginatedProductsResponse
{
    public function __construct(
        public PaginatedMetadata $meta,
        /** @var PaginatedProductsItem[] */
        public array $data,
    )
    {
    }

    public static function fromPagination(PaginationInterface $pagination) : self
    {
        $meta = new PaginatedMetadata(
            currentPage: (string) $pagination->getCurrentPageNumber(),
            limit: (string) $pagination->getItemNumberPerPage(),
            totalItems: (string) $pagination->getTotalItemCount(),
            totalPages: (string) $pagination->getPageCount()
        );

        $data = array_map(fn(ProductDto $item) => PaginatedProductsItem::fromDto($item), $pagination->getItems());

        return new self($meta, $data);
    }
}