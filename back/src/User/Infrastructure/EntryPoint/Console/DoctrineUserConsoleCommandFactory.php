<?php

declare(strict_types=1);

namespace App\User\Infrastructure\EntryPoint\Console;

use App\User\Domain\User;
use App\User\Domain\UserFactory;
use App\User\Domain\UserFactoryException;
use App\User\Infrastructure\Persistence\Doctrine\DoctrineUser;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class DoctrineUserConsoleCommandFactory implements UserFactory
{
    private const ALLOWED_ROLES = ['ROLE_USER', 'ROLE_ADMIN', 'ROLE_MASTER'];

    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    /**
     * @param array<array-key, mixed> $data
     */
    public function make(array $data): User
    {
        $this->validateData($data);
        $rawPassword = (string) $data['password'];
        $user = new DoctrineUser(
            (string) $data['mail'],
            (string) $data['name'],
            $rawPassword,
            $this->parseRoles($data),
            null,
            null
        );
        $hashedPassword = $this->hasher->hashPassword($user, $rawPassword);
        $user->setPassword($hashedPassword);
        return $user;
    }

    /**
     * @param array<array-key, mixed> $data
     * @return array<array-key, mixed>
     */
    private function parseRoles(array $data): array
    {
        if (!isset($data['role'])) {
            return ['ROLE_USER'];
        }
        /** @var string */
        foreach ($data['role'] as $role) {
            $this->validateRole($role);
        }
        return (array) $data['role'];
    }

    private function validateRole(string $role): void
    {
        if (!in_array($role, self::ALLOWED_ROLES)) {
            throw new UserFactoryException("Role {$role} not valid!!!!");
        }
    }

    /**
     * @param array<array-key, mixed> $data
     */
    private function validateData(array $data): void
    {
        if (!isset($data['mail']) || !isset($data['name']) || !isset($data['password'])) {
            throw new UserFactoryException('mail, name and password params are mandatory');
        }
    }
}
