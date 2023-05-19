<?php

declare(strict_types=1);

namespace App\User\Domain;

interface EmailSender
{
    public function send_email(string $from, string $to, string $text ): void;
}