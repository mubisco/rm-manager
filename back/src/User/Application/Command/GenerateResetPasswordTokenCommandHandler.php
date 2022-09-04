<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Domain\Event\EventBus;
use App\User\Domain\PasswordNotReseteableException;
use App\User\Domain\Username;
use App\User\Domain\UserNotFoundException;
use App\User\Domain\UserRepository;
use App\User\Domain\UserRepositoryException;
use App\User\Domain\WrongUsernameException;

class GenerateResetPasswordTokenCommandHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private EventBus $eventBus
    ) {
    }

    /**
     * @throws PasswordNotReseteableException
     * @throws WrongUsernameException
     * @throws UserRepositoryException
     * @throws UserNotFoundException
     */
    public function __invoke(GenerateResetPasswordTokenCommand $command): void
    {
        $username = new Username($command->username());
        $user = $this->userRepository->byUsername($username);
        $user->generateResetPasswordToken();
        $this->userRepository->update($user);
        $this->eventBus->sendEvents($user->pullEvents());
    }
}
