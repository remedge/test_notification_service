<?php

declare(strict_types=1);

namespace App\User\Infrastructure;

use App\User\Domain\EmailCheckResult;
use App\User\Domain\EmailCheckResultRepository;
use App\User\Domain\EmailValidator;

class DummyEmailValidator implements EmailValidator
{
    public function __construct(
        private readonly EmailCheckResultRepository $emailCheckResultRepository,
    ) {
    }

    public function validate(string $email): bool
    {
        // Check is email already stores in the inner DB
        $emailCheckResult = $this->emailCheckResultRepository->findByEmail($email);

        if ($emailCheckResult !== null) {
            return $emailCheckResult->isValid();
        }

        // If not, call the special "check_email" function and save the result to DB
        $emailCheckResult = new EmailCheckResult($email, $this->check_email($email));
        $this->emailCheckResultRepository->save($emailCheckResult);

        return $emailCheckResult->isValid();
    }

    private function check_email(string $email): bool
    {
        sleep(rand(1, 2));

        // Execute some remote function

        // Spent 1 RUB for execution

        return rand(0, 1) === 1;
    }
}