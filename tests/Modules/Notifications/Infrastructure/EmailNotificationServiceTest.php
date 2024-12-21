<?php
declare (strict_types=1);

namespace App\Tests\Modules\Notifications\Infrastructure;

use App\Modules\Notifications\Domain\Notification;
use App\Modules\Notifications\Infrastructure\EmailNotificationService;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailNotificationServiceTest extends TestCase
{
    private EmailNotificationService $emailNotificationService;
    private MailerInterface|MockObject $mailerMock;

    protected function setUp(): void
    {
        $this->mailerMock = $this->createMock(MailerInterface::class);
        $this->emailNotificationService = new EmailNotificationService($this->mailerMock);
    }

    public function testSend(): void
    {
        $notification = new Notification('fake@example.com', 'Gratulacje, został utworzony nowy produkt!');

        $expectedEmail = (new Email())
            ->from('boba.fett@kamino.xyz')
            ->to('fake@example.com')
            ->subject('Utworzono nowy produkt!')
            ->text('Gratulacje, został utworzony nowy produkt!');

        $this->mailerMock
            ->expects($this->once())
            ->method('send')
            ->with($this->callback(function (Email $sentEmail) use ($expectedEmail) {
                return $sentEmail->getFrom()[0]->getAddress() === $expectedEmail->getFrom()[0]->getAddress() &&
                    $sentEmail->getTo()[0]->getAddress() === $expectedEmail->getTo()[0]->getAddress() &&
                    $sentEmail->getSubject() === $expectedEmail->getSubject() &&
                    $sentEmail->getTextBody() === $expectedEmail->getTextBody();
            }));

        $this->emailNotificationService->send($notification);
    }
}