<?php

namespace App\User\Infrastructure\Persistence\Doctrine;

use App\User\Domain\User;
use App\User\Domain\Username;
use DateTimeImmutable;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Ulid;

class DoctrineUser implements UserInterface, PasswordAuthenticatedUserInterface, User
{
    private Ulid $userId;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    public function __construct(
        private string $email,
        private string $username,
        private string $password,
        private array $roles,
        private ?string $resetPasswordToken,
        private ?DateTimeImmutable $resetPasswordRequestedAt,
    ) {
        $this->userId = new Ulid();
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        /** @var array<array-key, string>*/
        return array_unique($roles);
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        $this->updatedAt = new DateTimeImmutable();
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function userId(): string
    {
        return $this->userId->__toString();
    }

    public function user(): string
    {
        return $this->username;
    }

    public function generateResetPasswordToken(): string
    {
    }
}
