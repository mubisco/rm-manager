<?php

declare(strict_types=1);

namespace App\Tests\unit\User\Infrastructure\Persistence\Doctrine;

use App\User\Infrastructure\Persistence\Doctrine\DoctrineUser;
use DateTimeImmutable;

final class DoctrineUserOM
{
    private string $email;
    private string $username;
    private string $password;
    private array $roles;
    private ?string $resetPasswordToken;
    private ?DateTimeImmutable $resetPasswordRequestedAt;

    public static function aUser(): self
    {
        return new self();
    }

    private function __construct()
    {
        $username = 'chindasvinto_' . microtime();
        $this->username = $username;
        $this->email = $username . '@random.mail';
        $this->password = 'someEncryptedPassword';
        $this->roles = ['ROLE_USER'];
        $this->resetPasswordToken = null;
        $this->resetPasswordRequestedAt = null;
    }

    public function build(): DoctrineUser
    {
        return new DoctrineUser(
            $this->email,
            $this->username,
            $this->password,
            $this->roles,
            $this->resetPasswordToken,
            $this->resetPasswordRequestedAt
        );
    }
}
