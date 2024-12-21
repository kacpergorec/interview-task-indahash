<?php
declare (strict_types=1);

namespace App\Tests\Modules\Notifications\Application;

use App\Modules\Notifications\Application\TriggerNotificationEventSubscriber;
use App\Modules\Notifications\Domain\Notification;
use App\Modules\Notifications\Domain\NotificationServiceInterface;
use App\Modules\Products\Domain\Events\ProductCreatedEvent;
use App\Modules\Products\Domain\ValueObjects\ProductId;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class TriggerNotificationEventSubscriberTest extends TestCase
{
    private TriggerNotificationEventSubscriber $subscriber;
    private NotificationServiceInterface|MockObject $notificationServiceMock;

    protected function setUp(): void
    {
        $this->notificationServiceMock = $this->createMock(NotificationServiceInterface::class);
        $this->subscriber = new TriggerNotificationEventSubscriber($this->notificationServiceMock);
    }

    public function testOnProductCreated(): void
    {
        $event = new ProductCreatedEvent(ProductId::new());

        $notification = new Notification('fake@example.com', 'Gratulacje, został utworzony nowy produkt!');

        $this->notificationServiceMock
            ->expects($this->once())
            ->method('send')
            ->with($this->equalTo($notification));

        $this->subscriber->onProductCreated($event);
    }

}
