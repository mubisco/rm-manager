<?php

declare(strict_types=1);

namespace App\User\Domain;

use InvalidArgumentException;
use Symfony\Component\Uid\Ulid;

final class UserId
{
    public static function fromEmpty(): self
    {
        $ulid = new Ulid();
        return new self($ulid->__toString());
    }

    public static function fromString(string $userId): self
    {
        if (!Ulid::isValid($userId)) {
            throw new InvalidArgumentException("Wrong User id provided: {$userId}");
        }
        return new self($userId);
    }
    private function __construct(private string $userId)
    {
    }
    public function value(): string
    {
        return $this->userId;
    }

    public function equalsTo(UserId $another): bool
    {
        return $another->value() == $this->userId;
    }
}
