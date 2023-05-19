<?php

declare(strict_types=1);

namespace App\User\Domain;

class EmailCheckResult
{
    public function __construct(
        private string $email,
        private bool $isValid,
    ) {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }
}