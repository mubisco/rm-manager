<?php

namespace App\User\Infrastructure\Persistence\Doctrine;

use App\Shared\Domain\Event\EventAware;
use App\User\Domain\PasswordChangeException;
use App\User\Domain\PasswordEncryptor;
use App\User\Domain\PasswordEncryptorException;
use App\User\Domain\PasswordNotReseteableException;
use App\User\Domain\PasswordToken;
use App\User\Domain\PasswordTokenWasRequested;
use App\User\Domain\User;
use App\User\Domain\UserId;
use App\User\Domain\UserPassword;
use App\User\Domain\UserWasCreated;
use DateTimeImmutable;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Ulid;

class DoctrineUser implements UserInterface, PasswordAuthenticatedUserInterface, User
{
    use EventAware;

    private const TOKEN_LIMIT_SECONDS = 3600;
    private Ulid $userId;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    /**
     * @param array<array-key, string> $roles
     */
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
        $this->addEvent(new UserWasCreated(
            (string) $this->userId,
            $this->username,
            $this->email
        ));
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
     * @psalm-suppress MissingReturnType
     * @return void
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function userId(): UserId
    {
        return UserId::fromString($this->userId->__toString());
    }

    public function user(): string
    {
        return $this->username;
    }

    public function generateResetPasswordToken(): string
    {
        if ($this->password == '') {
            throw new PasswordNotReseteableException('Could no reset empty password!!');
        }
        $token = PasswordToken::fromEmpty();
        $this->resetPasswordToken = $token->value();
        $this->resetPasswordRequestedAt = new DateTimeImmutable();
        $this->addEvent(new PasswordTokenWasRequested($this->userId->__toString()));
        return $this->resetPasswordToken ?? '';
    }

    public function passwordResetToken(): string
    {
        return $this->resetPasswordToken ?? '';
    }

    public function passwordResetTokenDate(): string
    {
        return $this->resetPasswordRequestedAt === null
            ? ''
            : $this->resetPasswordRequestedAt->format('Y-m-d H:i:s');
    }

    public function mail(): string
    {
        return $this->email;
    }

    public function isTokenExpired(): bool
    {
        if (is_null($this->resetPasswordRequestedAt)) {
            return true;
        }
        $tokenTimestamp = $this->resetPasswordRequestedAt->getTimestamp();
        $now = time();
        return $now - $tokenTimestamp > self::TOKEN_LIMIT_SECONDS;
    }

    public function updatePassword(PasswordEncryptor $passwordEncryptor, UserPassword $userPassword): void
    {
        try {
            $this->password = $passwordEncryptor->encryptPassword($this, $userPassword);
            $this->resetPasswordToken = '';
            $this->resetPasswordRequestedAt = null;
        } catch (PasswordEncryptorException $e) {
            throw new PasswordChangeException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
