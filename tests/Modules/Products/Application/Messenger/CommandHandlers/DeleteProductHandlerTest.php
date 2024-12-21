<?php
declare(strict_types=1);

namespace App\Tests\Modules\Products\Application\Messenger\CommandHandlers;

use App\Modules\Products\Application\Exception\ProductNotFoundException;
use App\Modules\Products\Application\Messenger\CommandHandlers\DeleteProductHandler;
use App\Modules\Products\Application\Messenger\Commands\DeleteProductCommand;
use App\Modules\Products\Domain\Entities\Product;
use App\Modules\Products\Domain\Repositories\ProductQueryRepositoryInterface;
use App\Modules\Products\Domain\Repositories\ProductRepositoryInterface;
use App\Modules\Products\Domain\ValueObjects\ProductId;
use App\Modules\Products\Infrastructure\Repositories\ProductQueryRepository;
use App\Modules\Products\Infrastructure\Repositories\ProductRepository;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\EventDispatcher\EventDispatcherInterface;

class DeleteProductHandlerTest extends TestCase
{
    private DeleteProductHandler $handler;
    private ProductRepositoryInterface|MockObject $productRepositoryMock;
    private ProductQueryRepositoryInterface|MockObject $productQueryRepositoryMock;
    private EventDispatcherInterface|MockObject $eventDispatcherMock;

    protected function setUp(): void
    {
        $this->productRepositoryMock = $this->createMock(ProductRepository::class);
        $this->productQueryRepositoryMock = $this->createMock(ProductQueryRepository::class);
        $this->eventDispatcherMock = $this->createMock(EventDispatcherInterface::class);

        $this->handler = new DeleteProductHandler(
            $this->productRepositoryMock,
            $this->productQueryRepositoryMock,
            $this->eventDispatcherMock
        );
    }

    public function testInvokeDeletesProduct(): void
    {
        $productId = ProductId::new();
        $product = Product::create($productId, 'Test Product', 'Description', new \App\Shared\Domain\Money(100));

        $command = new DeleteProductCommand($productId);

        $this->productQueryRepositoryMock
            ->expects($this->once())
            ->method('find')
            ->with($productId)
            ->willReturn($product);

        $this->productRepositoryMock
            ->expects($this->once())
            ->method('delete')
            ->with($product);

        $this->handler->__invoke($command);

        $this->assertTrue(true);
    }

    public function testInvokeThrowsExceptionIfProductNotFound(): void
    {
        $productId = ProductId::new();
        $command = new DeleteProductCommand($productId);

        $this->productQueryRepositoryMock
            ->expects($this->once())
            ->method('find')
            ->with($productId)
            ->willReturn(null);

        $this->expectException(ProductNotFoundException::class);
        $this->expectExceptionMessage('Product not found');

        $this->handler->__invoke($command);
    }
}
