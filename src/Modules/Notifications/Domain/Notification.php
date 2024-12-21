<?php
declare (strict_types=1);

namespace App\Modules\Notifications\Domain;

class Notification
{
    private string $recipient;
    private string $message;

    public function __construct(string $recipient, string $message)
    {
        $this->recipient = $recipient;
        $this->message = $message;
    }

    public function getRecipient(): string
    {
        return $this->recipient;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}