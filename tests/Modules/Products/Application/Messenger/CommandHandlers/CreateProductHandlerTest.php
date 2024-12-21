<?php
declare(strict_types=1);

namespace App\Tests\Modules\Products\Application\Messenger\CommandHandlers;

use App\Modules\Products\Application\Dtos\ProductDto;
use App\Modules\Products\Application\Messenger\CommandHandlers\CreateProductHandler;
use App\Modules\Products\Application\Messenger\Commands\CreateProductCommand;
use App\Modules\Products\Domain\Entities\Product;
use App\Modules\Products\Domain\Events\ProductCreatedEvent;
use App\Modules\Products\Domain\Repositories\ProductRepositoryInterface;
use App\Modules\Products\Domain\ValueObjects\ProductId;
use App\Modules\Products\Infrastructure\Repositories\ProductRepository;
use App\Shared\Domain\Money;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\EventDispatcher\EventDispatcherInterface;

class CreateProductHandlerTest extends TestCase
{
    private CreateProductHandler $handler;
    private ProductRepositoryInterface|MockObject $productRepositoryMock;
    private EventDispatcherInterface|MockObject $eventDispatcherMock;

    protected function setUp(): void
    {
        $this->productRepositoryMock = $this->createMock(ProductRepository::class);
        $this->eventDispatcherMock = $this->createMock(EventDispatcherInterface::class);

        $this->handler = new CreateProductHandler(
            $this->productRepositoryMock,
            $this->eventDispatcherMock
        );
    }

    public function testInvokeCreatesProduct(): void
    {
        $productId = ProductId::new();
        $dto = new ProductDto(
            id : $productId,
            name : 'New Product',
            description : 'Product description',
            grossPrice : new Money(300)
        );

        $command = new CreateProductCommand($dto);

        $product = Product::create($productId, 'New Product', 'Product description', new Money(300));

        $this->productRepositoryMock
            ->expects($this->once())
            ->method('save')
            ->with($product);

        $this->handler->__invoke($command);

        $this->assertSame('New Product', $product->getName());
        $this->assertSame('Product description', $product->getDescription());
        $this->assertTrue($product->getGrossPrice()->isEqual(new Money(300)));
    }

    public function testInvokeDispatchesEvents(): void
    {
        $productId = ProductId::new();
        $dto = new ProductDto(
            id : $productId,
            name : 'New Product',
            description : 'Product description',
            grossPrice : new Money(300)
        );
        $command = new CreateProductCommand($dto);

        $this->eventDispatcherMock
            ->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(ProductCreatedEvent::class));

        $this->handler->__invoke($command);
    }
}
