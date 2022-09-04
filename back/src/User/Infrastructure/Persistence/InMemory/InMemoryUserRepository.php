<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Persistence\InMemory;

use App\User\Domain\User;
use App\User\Domain\UserId;
use App\User\Domain\UserRepository;
use App\User\Domain\Username;
use App\User\Domain\UserNotFoundException;
use App\User\Infrastructure\Persistence\Doctrine\DoctrineUser;

final class InMemoryUserRepository implements UserRepository
{
    /** @var User[] */
    private array $users;

    public function __construct()
    {
        $this->users = [
            new DoctrineUser('some@email.net', 'existinguser', 'password', ['ROLE_USER'], null, null)
        ];
    }
    public function byUsername(Username $username): User
    {
        foreach ($this->users as $user) {
            if ($user->user() == $username->value()) {
                return $user;
            }
        }
        throw new UserNotFoundException("User {$username->value()} not found!!!");
    }

    public function update(User $user): User
    {
        return $user;
    }

    public function ofId(UserId $userId): User
    {
        foreach ($this->users as $user) {
            if ($userId->equalsTo($user->userId())) {
                return $user;
            }
        }
        throw new UserNotFoundException(
            "User with id {$userId->value()} not found"
        );
    }
}
