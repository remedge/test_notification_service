<?php

declare(strict_types=1);

namespace App\User\Domain;

interface EmailCheckResultRepository
{
    public function save(EmailCheckResult $email): void;

    public function findByEmail(string $email): ?EmailCheckResult;
}