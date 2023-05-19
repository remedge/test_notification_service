<?php

declare(strict_types=1);

namespace App\User\Application;

use App\User\Domain\EmailSender;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class EmailNotificationHandler
{
    private const EMAIL_FROM = 'from@email.com';

    public function __construct(
        private EmailSender $emailSender,
    )
    {
    }

    public function __invoke(EmailNotification $message): void
    {
        $this->emailSender->send_email(self::EMAIL_FROM, $message->email, $message->content);
    }
}