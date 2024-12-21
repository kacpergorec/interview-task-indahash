<?php
declare (strict_types=1);

namespace App\Modules\Products\Application\EventSubscribers;

use App\Modules\Products\Application\Events\ProductDeletionRequestEvent;
use App\Modules\Products\Application\Events\ProductUpdateRequestEvent;
use App\Modules\Products\Application\Messenger\Commands\DeleteProductCommand;
use App\Modules\Products\Application\Messenger\Commands\UpdateProductCommand;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsEventListener]
readonly class ProductUpdateRequestEventSubscriber
{
    public function __construct(
        private MessageBusInterface $bus
    )
    {
    }

    public function __invoke(ProductUpdateRequestEvent $event): void
    {
        $this->bus->dispatch(
            new UpdateProductCommand(
                productId: $event->productId,
                name: $event->name,
                description: $event->description,
                grossPrice: $event->grossPrice
            )
        );
    }
}