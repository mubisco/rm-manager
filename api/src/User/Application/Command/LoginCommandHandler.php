<?php

namespace App\User\Application\Command;

use App\Shared\Application\CommandHandlerInterface;
use App\User\Domain\UserEmail;
use App\User\Domain\UserPassword;
use App\User\Domain\UserRepository;

final class LoginCommandHandler implements CommandHandlerInterface
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function __invoke(LoginCommand $command): LoginDto
    {
        $userEmail = new UserEmail($command->email());
        $userPassword = new UserPassword($command->password());
        $user = $this->userRepository->login($userEmail, $userPassword);
        return LoginDto::fromUser($user);
    }
}
