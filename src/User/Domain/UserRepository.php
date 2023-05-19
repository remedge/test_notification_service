<?php

declare(strict_types=1);

namespace App\User\Domain;

use DateTimeImmutable;

interface UserRepository
{
    public function save(User $user): void;

    /**
     * @return array<{username: string, email: string}>
     */
    public function findConfirmedUsersWithExpirationDate(
        DateTimeImmutable $expirationDate,
    ): array;
}