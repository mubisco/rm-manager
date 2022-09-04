<?php

declare(strict_types=1);

namespace App\Shared\Domain\Event;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

final class PersistibleEventId
{
    public static function fromString(string $id): self
    {
        return new self($id);
    }
    public static function fromEmpty(): self
    {
        return new self('64efd6b7-7f81-4434-9f88-299b9858281d');
    }

    private function __construct(private string $id)
    {
        if (!Uuid::isValid($id)) {
            throw new InvalidArgumentException(
                "Provided Uuid not valid: {$id}"
            );
        }
    }

    public function value(): string
    {
        return $this->id;
    }
}
