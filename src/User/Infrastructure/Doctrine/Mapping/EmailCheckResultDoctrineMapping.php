<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Mapping;

use App\Shared\Infrastructure\Doctrine\Mapping\DoctrineMapping;
use App\User\Domain\EmailCheckResult;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;

class EmailCheckResultDoctrineMapping extends DoctrineMapping
{
    public function __construct()
    {
        parent::__construct(EmailCheckResult::class);
    }

    public function configure(ClassMetadataBuilder $builder): void
    {
        $builder->setTable('email_check_results');

        $builder->createField('email', 'string')
            ->unique()
            ->makePrimaryKey()
            ->build();

        $builder->addField('isValid', 'boolean');
    }
}