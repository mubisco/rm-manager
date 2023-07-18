<?php

declare(strict_types=1);

namespace App\Character\Domain\Profession;

use InvalidArgumentException;

final class ProfessionLanguage
{
    private const ALLOWED_VALUES = ['es', 'en'];

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function __construct(private readonly string $value)
    {
        if (!in_array($value, self::ALLOWED_VALUES)) {
            throw new InvalidArgumentException("[{$value}] is not a valid Language!!!");
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}
