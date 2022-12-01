<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Application\CommandHandlerInterface;
use App\User\Domain\PasswordChangeException;
use App\User\Domain\PasswordEncryptor;
use App\User\Domain\PasswordEncryptorException;
use App\User\Domain\Username;
use App\User\Domain\UserNotFoundException;
use App\User\Domain\UserPassword;
use App\User\Domain\UserRepository;
use App\User\Domain\UserRepositoryException;
use App\User\Domain\WrongPasswordFormatException;
use App\User\Domain\WrongUsernameException;

final class ChangeUserPasswordCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepository $userRepository,
        private PasswordEncryptor $passwordEncryptor
    ) {
    }

    public function __invoke(ChangeUserPasswordCommand $command): void
    {
        try {
            $user = new Username($command->username);
            $password = new UserPassword($command->newPassword);
            $user = $this->userRepository->byUsername($user);
            $user->updatePassword($this->passwordEncryptor, $password);
            $this->userRepository->update($user);
        } catch (
            WrongUsernameException |
            WrongPasswordFormatException |
            UserNotFoundException |
            UserRepositoryException |
            PasswordEncryptorException $e
        ) {
            throw new PasswordChangeException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
