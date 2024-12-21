<?php
declare (strict_types=1);

namespace App\Modules\Products\Application\EventSubscribers;

use App\Modules\Products\Application\Messenger\Commands\CreateProductCommand;
use App\Modules\Products\Application\Events\ProductCreationRequestEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsEventListener]
readonly class ProductCreationRequestEventSubscriber
{
    public function __construct(
        private MessageBusInterface $bus
    )
    {
    }

    public function __invoke(ProductCreationRequestEvent $event): void
    {
        $this->bus->dispatch(
            new CreateProductCommand($event->productDto)
        );
    }
}