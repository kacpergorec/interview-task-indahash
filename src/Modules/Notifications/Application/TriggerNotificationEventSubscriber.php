<?php
declare (strict_types=1);

namespace App\Modules\Notifications\Application;

use App\Modules\Notifications\Domain\Notification;
use App\Modules\Notifications\Domain\NotificationServiceInterface;
use App\Modules\Products\Domain\Events\ProductCreatedEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;


#[AsEventListener(event: ProductCreatedEvent::class, method: 'onProductCreated')]
readonly class TriggerNotificationEventSubscriber
{

    public function __construct(
      private NotificationServiceInterface $notificationService
    )
    {
    }

    public function onProductCreated(ProductCreatedEvent $event): void
    {
        $notification = new Notification('fake@example.com', 'Gratulacje, został utworzony nowy produkt!');

        $this->notificationService->send($notification);
    }

}