<?php

declare(strict_types=1);

namespace App\User\Domain;

interface EmailValidator
{
    public function validate(string $email): bool;
}