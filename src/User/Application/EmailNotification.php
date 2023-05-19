<?php

declare(strict_types=1);

namespace App\User\Application;

class EmailNotification
{
    public function __construct(
        public string $email,
        public string $content,
    ) {
    }
}