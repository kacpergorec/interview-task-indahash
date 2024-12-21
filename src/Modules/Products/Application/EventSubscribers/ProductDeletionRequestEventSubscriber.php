<?php
declare (strict_types=1);

namespace App\Modules\Products\Application\EventSubscribers;

use App\Modules\Products\Application\Events\ProductDeletionRequestEvent;
use App\Modules\Products\Application\Messenger\Commands\DeleteProductCommand;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsEventListener]
readonly class ProductDeletionRequestEventSubscriber
{
    public function __construct(
        private MessageBusInterface $bus
    )
    {
    }

    public function __invoke(ProductDeletionRequestEvent $event): void
    {
        $this->bus->dispatch(
            new DeleteProductCommand($event->productId)
        );
    }
}