<?php
declare (strict_types=1);

namespace App\Modules\Products\Application\Messenger\CommandHandlers;

use App\Modules\Products\Application\Messenger\Commands\CreateProductCommand;
use App\Modules\Products\Domain\Entities\Product;
use App\Modules\Products\Domain\Repositories\ProductRepositoryInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class CreateProductHandler  //todo: unit test this class
{
    public function __construct(
        public ProductRepositoryInterface $productRepository,
        public EventDispatcherInterface   $eventDispatcher
    )
    {
    }

    public function __invoke(CreateProductCommand $command): void
    {
        $Dto = $command->productDto;

        $product = Product::create(
            id: $Dto->id,
            name: $Dto->name,
            description: $Dto->description,
            grossPrice: $Dto->grossPrice
        );

        $this->productRepository->save($product);

        foreach ($product->pullEvents() as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }
}