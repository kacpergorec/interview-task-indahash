<?php
declare (strict_types=1);

namespace App\Modules\Products\Application\Messenger\CommandHandlers;

use App\Modules\Products\Application\Exception\ProductNotFoundException;
use App\Modules\Products\Application\Messenger\Commands\DeleteProductCommand;
use App\Modules\Products\Domain\Repositories\ProductQueryRepositoryInterface;
use App\Modules\Products\Domain\Repositories\ProductRepositoryInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class DeleteProductHandler  //todo: unit test this class
{
    public function __construct(
        public ProductRepositoryInterface $productRepository,
        public ProductQueryRepositoryInterface $productQueryRepository,
        public EventDispatcherInterface   $eventDispatcher
    )
    {
    }

    public function __invoke(DeleteProductCommand $command): void
    {
        $product = $this->productQueryRepository->find($command->productId);

        if (!$product) {
            throw new ProductNotFoundException('Product not found');
        }

        $this->productRepository->delete($product);
    }
}