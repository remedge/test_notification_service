<?php

declare(strict_types=1);

namespace App\User\Presentation\Cli;
use App\Shared\Application\Clock;
use App\User\Application\EmailNotification;
use App\User\Domain\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(name: 'user:check-subscriptions-expiration')]
class CheckUserSubscriptionsExpirationCommand extends Command
{
    public function __construct(
        private readonly Clock $clock,
        private readonly UserRepository $userRepository,
        private MessageBusInterface $messageBus,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Check for 3 days expiration
        $endDate = $this->clock->now()->modify('+3 days')->setTime(0, 0, 0);
        $users = $this->userRepository->findConfirmedUsersWithExpirationDate($endDate);

        // Send notification to queue
        foreach ($users as $user) {
            $this->messageBus->dispatch(new EmailNotification(
                email: $user['email'],
                content: sprintf( "%s, your subscription is expiring in 3 days", $user['username'])
            ));
        }

        // Check for 1 days expiration
        $endDate = $this->clock->now()->modify('+1 days')->setTime(0, 0, 0);
        $users = $this->userRepository->findConfirmedUsersWithExpirationDate($endDate);

        // Send notification to queue
        foreach ($users as $user) {
            $this->messageBus->dispatch(new EmailNotification(
                email: $user['email'],
                content: sprintf( "%s, your subscription is expiring in 1 days", $user['username'])
            ));
        }

        return Command::SUCCESS;
    }
}