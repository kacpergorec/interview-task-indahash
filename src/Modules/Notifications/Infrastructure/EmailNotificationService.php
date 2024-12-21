<?php
declare (strict_types=1);

namespace App\Modules\Notifications\Infrastructure;

use App\Modules\Notifications\Domain\Notification;
use App\Modules\Notifications\Domain\NotificationServiceInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailNotificationService implements NotificationServiceInterface
{
    public function __construct(
        private MailerInterface $mailer
    )
    {
    }

    public function send(Notification $notification): void
    {
        $email = (new Email())
            ->from('boba.fett@kamino.xyz')
            ->to($notification->getRecipient())
            ->subject('Utworzono nowy produkt!')
            ->text($notification->getMessage());

        $this->mailer->send($email);
    }
}