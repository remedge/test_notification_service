<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Repository;

use App\User\Domain\User;
use App\User\Domain\UserRepository;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class DoctrineUserRepository extends ServiceEntityRepository implements UserRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $user): void
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function findConfirmedUsersWithExpirationDate(DateTimeImmutable $expirationDate): array
    {
        $qb = $this->createQueryBuilder('u');
        $qb->select('u.username, u.email');
        $qb->where('u.confirmed = true');
        $qb->andWhere('u.validts = :expirationDate');
        $qb->setParameter('expirationDate', $expirationDate);

        return $qb->getQuery()->getResult();
    }
}