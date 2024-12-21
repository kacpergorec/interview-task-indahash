<?php
declare (strict_types=1);

namespace App\Tests\Modules\Products\Application\Messenger\CommandHandlers;

use App\Modules\Products\Application\Messenger\CommandHandlers\UpdateProductHandler;
use App\Modules\Products\Application\Messenger\Commands\UpdateProductCommand;
use App\Modules\Products\Domain\Entities\Product;
use App\Modules\Products\Domain\Repositories\ProductQueryRepositoryInterface;
use App\Modules\Products\Domain\Repositories\ProductRepositoryInterface;
use App\Modules\Products\Domain\ValueObjects\ProductId;
use App\Modules\Products\Infrastructure\Repositories\ProductQueryRepository;
use App\Modules\Products\Infrastructure\Repositories\ProductRepository;
use App\Shared\Domain\Money;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class UpdateProductHandlerTest extends TestCase
{
    private UpdateProductHandler $handler;
    private ProductRepositoryInterface|MockObject $productRepositoryMock;
    private ProductQueryRepositoryInterface|MockObject $productQueryRepositoryMock;
    private EventDispatcherInterface|MockObject $eventDispatcherMock;

    protected function setUp(): void
    {
        $this->productRepositoryMock = $this->createMock(ProductRepository::class);
        $this->productQueryRepositoryMock = $this->createMock(ProductQueryRepository::class);
        $this->eventDispatcherMock = $this->createMock(EventDispatcher::class);

        $this->handler = new UpdateProductHandler(
            $this->productRepositoryMock,
            $this->productQueryRepositoryMock,
            $this->eventDispatcherMock
        );
    }

    public function testInvokeUpdatesProduct(): void
    {
        $productId = ProductId::new();
        $command = new UpdateProductCommand(
            $productId,
            name: 'Updated Product Name',
            description: 'Updated description',
            grossPrice: new Money(200)
        );

        $product = Product::create($productId, 'Original Product', 'Original description', new Money(500));

        $this->productQueryRepositoryMock
            ->expects($this->once())
            ->method('find')
            ->with($productId)
            ->willReturn($product);

        $this->productRepositoryMock
            ->expects($this->once())
            ->method('save')
            ->with($product);

        $this->handler->__invoke($command);

        $this->assertSame('Updated Product Name', $product->getName());
        $this->assertSame('Updated description', $product->getDescription());
        $this->assertTrue($product->getGrossPrice()->isEqual(new Money(200)));
    }
}