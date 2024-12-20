<?php
declare (strict_types=1);

namespace App\Tests\Unit\Modules\Products\Domain\Entities;

use App\Modules\Products\Domain\Entities\Product;
use App\Modules\Products\Domain\Events\ProductCreatedEvent;
use App\Modules\Products\Domain\ValueObjects\ProductId;
use App\Shared\Domain\Money;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testCreateProduct(): void
    {
        $id = ProductId::new();

        $product = Product::create(
            id: $id,
            name: 'X-Wing',
            description: 'A starfighter used by the Rebel Alliance',
            grossPrice: new Money(50000)
        );

        $this->assertTrue($product->id instanceof ProductId);
        $this->assertContains(ProductCreatedEvent::class, array_map(fn($event) => $event::class, $product->pullEvents()));
    }

}
