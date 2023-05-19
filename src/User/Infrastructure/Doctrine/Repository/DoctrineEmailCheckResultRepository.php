<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Repository;

use App\User\Domain\EmailCheckResult;
use App\User\Domain\EmailCheckResultRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EmailCheckResult>
 */
class DoctrineEmailCheckResultRepository extends ServiceEntityRepository implements EmailCheckResultRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmailCheckResult::class);
    }

    public function save(EmailCheckResult $email): void
    {
        $this->_em->persist($email);
        $this->_em->flush();
    }

    public function findByEmail(string $email): ?EmailCheckResult
    {
        return $this->findOneBy(['email' => $email]);
    }
}