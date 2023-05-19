<?php

declare(strict_types=1);

namespace App\User\Domain;

use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;

class User
{
    public function __construct(
        private UuidInterface $id,
        private string $username,
        private string $email,
        private DateTimeImmutable $validts,
        private bool $confirmed = false,
    ) {
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getValidts(): DateTimeImmutable
    {
        return $this->validts;
    }

    public function isConfirmed(): bool
    {
        return $this->confirmed;
    }
}