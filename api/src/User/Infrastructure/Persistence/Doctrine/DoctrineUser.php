<?php

namespace App\User\Infrastructure\Persistence\Doctrine;

use App\User\Domain\User;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Ulid;

class DoctrineUser implements UserInterface, PasswordAuthenticatedUserInterface, User
{
    private Ulid $userId;

    public function __construct(
        private string $email,
        private string $username,
        private string $password,
        private array $roles,
    ) {
        $this->userId = new Ulid();
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
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
        return $this->email;
    }

    public function role(): string
    {
        return 'ADMIN';
    }

    public function token(): string
    {
        return 'token';
    }
}
