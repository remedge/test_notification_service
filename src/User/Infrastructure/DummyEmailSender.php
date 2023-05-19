<?php

declare(strict_types=1);

namespace App\User\Infrastructure;

use App\User\Domain\EmailSender;

class DummyEmailSender implements EmailSender
{
    public function send_email(string $from, string $to, string $text): void
    {
        sleep(rand(1, 10));

        // Execute email sending
        dump("Sending email from $from to $to with content: $text");
    }
}