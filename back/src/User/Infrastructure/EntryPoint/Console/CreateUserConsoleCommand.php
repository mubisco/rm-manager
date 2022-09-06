<?php

declare(strict_types=1);

namespace App\User\Infrastructure\EntryPoint\Console;

use App\User\Application\Command\CreateUserCommand;
use InvalidArgumentException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'user:create'
)]
final class CreateUserConsoleCommand extends Command
{
    public function __construct(private MessageBusInterface $commandBus, string $name = null)
    {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setHelp('Creates a new user');
        $this->addArgument(
            'name',
            InputArgument::REQUIRED,
            'User name. Should be all undercase letters with no especial characters'
        );
        $this->addArgument(
            'mail',
            InputArgument::REQUIRED,
            'User mail. Must be a valid Email'
        );
        $this->addArgument(
            'password',
            InputArgument::REQUIRED,
            'User password. For initialization purposes'
        );
        $this->addOption(
            'role',
            null,
            InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
            'Role for the user. Should be one or more of these: ROLE_USER, ROLE_ADMIN, ROLE_MASTER. ' .
                'If no role passed, its assumed a ROLE_USER option'
        );
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $data = $input->getArguments();
            $data['role'] = $input->getOption('role');
            $command = new CreateUserCommand($data);
            $this->commandBus->dispatch($command);
        } catch (InvalidArgumentException $e) {
            $output->writeln($e->getMessage());
            return Command::FAILURE;
        }
        $output->writeln('User created successfully');
        return Command::SUCCESS;
    }
}
