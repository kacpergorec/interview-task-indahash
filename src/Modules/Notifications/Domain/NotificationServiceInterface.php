<?php
declare (strict_types=1);

namespace App\Modules\Notifications\Domain;

interface NotificationServiceInterface
{
    public function send(Notification $notification): void;
}