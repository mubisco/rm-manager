<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Application\CommandHandlerInterface;
use App\User\Domain\PasswordChangeException;
use App\User\Domain\PasswordEncryptor;
use App\User\Domain\PasswordToken;
use App\User\Domain\PasswordTokenExpiredException;
use App\User\Domain\PasswordTokenNotFoundException;
use App\User\Domain\UserPassword;
use App\User\Domain\UserRepository;
use App\User\Domain\UserRepositoryException;
use InvalidArgumentException;

class ChangePasswordCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepository $userRepository,
        private PasswordEncryptor $passwordEncryptor
    ) {
    }
    /**
     * @throws PasswordChangeException If password cannot be changed
     */
    public function __invoke(ChangePasswordCommand $command): void
    {
        try {
            $password = new UserPassword($command->password());
            $passwordToken = PasswordToken::fromString($command->token());
            $user = $this->userRepository->ofValidPasswordToken($passwordToken);
            $user->updatePassword($this->passwordEncryptor, $password);
            $this->userRepository->update($user);
        } catch (
            InvalidArgumentException |
            UserRepositoryException |
            PasswordTokenNotFoundException |
            PasswordTokenExpiredException $e
        ) {
            throw new PasswordChangeException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
