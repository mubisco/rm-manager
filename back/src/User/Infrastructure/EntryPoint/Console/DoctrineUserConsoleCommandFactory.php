<?php

declare(strict_types=1);

namespace App\User\Infrastructure\EntryPoint\Console;

use App\User\Domain\User;
use App\User\Domain\UserFactory;
use App\User\Domain\UserFactoryException;
use App\User\Infrastructure\Persistence\Doctrine\DoctrineUser;

final class DoctrineUserConsoleCommandFactory implements UserFactory
{
    private const ALLOWED_ROLES = ['ROLE_USER', 'ROLE_ADMIN', 'ROLE_MASTER'];
    public function make(array $data): User
    {
        $this->validateData($data);
        return new DoctrineUser(
            (string) $data['mail'],
            (string) $data['name'],
            (string) $data['password'],
            $this->parseRoles($data),
            null,
            null
        );
    }

    /**
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

    private function validateData(array $data): void
    {
        if (!isset($data['mail']) || !isset($data['name']) || !isset($data['password'])) {
            throw new UserFactoryException('mail, name and password params are mandatory');
        }
    }
}
