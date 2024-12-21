<?php
declare (strict_types=1);

namespace App\Modules\Products\Application\Messenger\CommandHandlers;

use App\Modules\Products\Application\Messenger\Commands\CreateProductCommand;
use App\Modules\Products\Application\Messenger\Commands\UpdateProductCommand;
use App\Modules\Products\Application\Messenger\QueryHandlers\GetProductHandler;
use App\Modules\Products\Domain\Entities\Product;
use App\Modules\Products\Domain\Repositories\ProductQueryRepositoryInterface;
use App\Modules\Products\Domain\Repositories\ProductRepositoryInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class UpdateProductHandler  //todo: unit test this class
{
    public function __construct(
        public ProductRepositoryInterface      $productRepository,
        public ProductQueryRepositoryInterface $productQueryRepository,
        public EventDispatcherInterface        $eventDispatcher
    )
    {
    }

    public function __invoke(UpdateProductCommand $command): void
    {
        $product = $this->productQueryRepository->find($command->productId);

        if ($command->name) {
            $product->setName($command->name);
        }

        if ($command->description) {
            $product->setDescription($command->description);
        }

        if ($command->grossPrice) {
            $product->setGrossPrice($command->grossPrice);
        }

        $this->productRepository->save($product);

        foreach ($product->pullEvents() as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }
}