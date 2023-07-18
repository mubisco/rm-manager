<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Persistence\InMemory;

use App\User\Domain\PasswordToken;
use App\User\Domain\PasswordTokenExpiredException;
use App\User\Domain\PasswordTokenNotFoundException;
use App\User\Domain\User;
use App\User\Domain\UserId;
use App\User\Domain\UserRepository;
use App\User\Domain\Username;
use App\User\Domain\UserNotFoundException;
use App\User\Infrastructure\Persistence\Doctrine\DoctrineUser;
use DateTimeImmutable;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class InMemoryUserRepository implements UserRepository, UserProviderInterface
{
    /** @var User[] */
    private array $users;

    public function __construct()
    {
        $this->users = [
            new DoctrineUser('some@email.net', 'existinguser', 'password', ['ROLE_USER'], null, null),
            new DoctrineUser(
                'expired@token.net',
                'expiredTokenUser',
                'password',
                ['ROLE_USER'],
                '99c54fef52e9b2db8085d0f588ef8c96f8eb0f3f473456e939eaade887183507',
                new DateTimeImmutable('2020-12-12')
            ),
            new DoctrineUser(
                'reseteable@token.net',
                'validTokenUser',
                'password',
                ['ROLE_USER'],
                '10c54fef52e9b2db8085d0f588ef8c96f8eb0f3f473456e939eaade887183507',
                new DateTimeImmutable()
            )
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

    public function store(User $user): User
    {
        $this->users[] = $user;
        return $user;
    }

    public function ofValidPasswordToken(PasswordToken $token): User
    {
        $userWithToken = null;
        foreach ($this->users as $user) {
            if ($user->passwordResetToken() == $token->value()) {
                $userWithToken = $user;
            }
        }
        if (!$userWithToken) {
            throw new PasswordTokenNotFoundException("Token {$token->value()} not found!!!");
        }
        if ($userWithToken->isTokenExpired()) {
            throw new PasswordTokenExpiredException("Token {$token->value()} expired!!!");
        }
        return $userWithToken;
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $user;
    }

    public function supportsClass(string $class): bool
    {
        throw new \RuntimeException(sprintf('Implement %s', __METHOD__));
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        /** @var DoctrineUser */
        foreach ($this->users as $user) {
            if ($user->user() == $identifier) {
                return $user;
            }
        }
        throw new UserNotFoundException("User {$identifier} not found!!!");
    }
}
