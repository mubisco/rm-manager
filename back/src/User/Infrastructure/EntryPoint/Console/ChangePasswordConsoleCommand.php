<?php

declare(strict_types=1);

namespace App\User\Infrastructure\EntryPoint\Console;

use App\User\Application\Command\ChangeUserPasswordCommand;
use App\User\Domain\PasswordChangeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'user:password:change',
    description: 'Changes password for a given user',
    hidden: false,
    aliases: ['pass:change']
)]
final class ChangePasswordConsoleCommand extends Command
{
    public function __construct(private MessageBusInterface $commandBus, string $name = null)
    {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->addArgument(
            'name',
            InputArgument::REQUIRED,
            'User name. Should be all undercase letters with no especial characters'
        );
        $this->addArgument(
            'new-password',
            InputArgument::REQUIRED,
            'New password to assign to given user'
        );
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $name = $input->getArgument('name');
            $password = $input->getArgument('new-password');
            $command = new ChangeUserPasswordCommand($name, $password);
            $this->commandBus->dispatch($command);
            $output->writeln('User created successfully');
            return Command::SUCCESS;
        } catch (PasswordChangeException $e) {
            $output->writeln($e->getMessage());
            return Command::FAILURE;
        }
    }
}
