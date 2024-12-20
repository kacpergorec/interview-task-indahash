<?php
declare (strict_types=1);

namespace App\Tests\Feature;

use App\Modules\Products\Domain\Entities\Product;
use App\Modules\Products\Domain\Events\ProductCreatedEvent;
use App\Modules\Products\Domain\ValueObjects\ProductId;
use App\Modules\Products\Infrastructure\Repositories\ProductQueryRepository;
use App\Modules\Products\Infrastructure\Repositories\ProductRepository;
use App\Shared\Domain\Money;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductLifecycleTest extends KernelTestCase
{
    private ManagerRegistry $managerRegistry;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        /** @var ManagerRegistry $managerRegistry */
        $managerRegistry = $kernel->getContainer()->get('doctrine');
        $this->managerRegistry = $managerRegistry;
    }

    public function testSaveAndDeleteProduct(): void
    {
        // Arrange
        $id = ProductId::new();
        $product = Product::create(
            id: $id,
            name: 'X-Wing',
            description: 'A starfighter used by the Rebel Alliance',
            grossPrice: new Money(700)
        );

        // Act
        $repository = new ProductRepository($this->managerRegistry);
        $repository->save($product);

        // Assert
        $this->assertTrue($product->id instanceof ProductId);
        $this->assertIsString($product->getName());
        $this->assertIsString($product->getDescription());
        $this->assertTrue($product->getGrossPrice() instanceof Money);

        $this->assertContains(ProductCreatedEvent::class, array_map(fn($event) => $event::class, $product->pullEvents()));
    }

    public function testDeleteProduct(): void
    {
        // Arrange
        $id = ProductId::new();
        $product = Product::create(
            id: $id,
            name: 'X-Wing',
            description: 'A starfighter used by the Rebel Alliance',
            grossPrice: new Money(700)
        );
        $repository = new ProductRepository($this->managerRegistry);
        $queryRepository = new ProductQueryRepository($this->managerRegistry);

        // Act
        $repository->save($product);
        $repository->delete($product);

        // Assert
        $this->assertNull($queryRepository->find($id));
    }


    protected function tearDown(): void
    {
//         code obviously not to be used in production :)
        $connection = $this->managerRegistry->getConnection();
        $connection->executeStatement('TRUNCATE TABLE product');
    }
}
