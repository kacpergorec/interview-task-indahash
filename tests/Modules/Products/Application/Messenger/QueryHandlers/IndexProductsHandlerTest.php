<?php

namespace App\Tests\Modules\Products\Application\Messenger\QueryHandlers;

use App\Modules\Products\Application\Factories\DtoFactory;
use App\Modules\Products\Application\Messenger\Queries\IndexProductsQuery;
use App\Modules\Products\Application\Messenger\QueryHandlers\IndexProductsHandler;
use App\Modules\Products\Domain\Entities\Product;
use App\Modules\Products\Domain\Repositories\ProductQueryRepositoryInterface;
use App\Shared\Enums\SortDirection;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class IndexProductsHandlerTest extends TestCase
{
    private ProductQueryRepositoryInterface|MockObject $productQueryRepository;
    private PaginatorInterface|MockObject $paginator;
    private IndexProductsHandler $handler;

    protected function setUp(): void
    {
        $this->productQueryRepository = $this->createMock(ProductQueryRepositoryInterface::class);
        $this->paginator = $this->createMock(PaginatorInterface::class);
        $this->handler = new IndexProductsHandler($this->productQueryRepository, $this->paginator);
    }

    public function testInvokeReturnsPaginationInterfaceWithDtoItems(): void {
        $query = new IndexProductsQuery(SortDirection::ASC, 'name', 1, 10);

        $product = Product::create(\App\Modules\Products\Domain\ValueObjects\ProductId::new(), 'Test Product', 'Description', new \App\Shared\Domain\Money(100));
        $products = [$product];

        $paginationMock = $this->createMock(PaginationInterface::class);
        $paginationMock->expects($this->once())
            ->method('getItems')
            ->willReturn($products);

        $this->paginator->expects($this->once())
            ->method('paginate')
            ->willReturn($paginationMock);


        $paginationMock->expects($this->once())
            ->method('setItems')
            ->with(array_map(fn(Product $p) => DtoFactory::createFromEntity($p), $products));

        $result = ($this->handler)($query);

        $this->assertInstanceOf(PaginationInterface::class, $result);
    }

}