<?php

declare(strict_types=1);

namespace App\User\Presentation\Cli;

use App\Shared\Application\Clock;
use App\Shared\Application\UuidProvider;
use App\User\Domain\EmailValidator;
use App\User\Domain\User;
use App\User\Domain\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'user:create')]
class CreateUserCommand extends Command
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UuidProvider $uuidProvider,
        private readonly Clock $clock,
        private readonly EmailValidator $emailValidator,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Creates a new user.')
            ->setHelp('This command allows you to create a user...')
            ->addArgument('username', InputArgument::REQUIRED, 'Username')
            ->addArgument('email', InputArgument::REQUIRED, 'Email');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($this->emailValidator->validate($input->getArgument('email')) === false) {
            $output->writeln('Invalid email');
            return Command::FAILURE;
        }

        $this->userRepository->save(new User(
            id: $this->uuidProvider->provide(),
            username: $input->getArgument('username'),
            email: $input->getArgument('email'),
            validts: $this->clock->now()->modify('+1 month'),
        ));
        return Command::SUCCESS;
    }
}