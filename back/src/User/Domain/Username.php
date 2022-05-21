<?php

declare(strict_types=1);

namespace App\User\Domain;

final class Username
{
    private const USERNAME_REGEX = '/^[0-9a-zA-Z_]{3,}$/';

    public function __construct(private string $value)
    {
        if (!preg_match(self::USERNAME_REGEX, $value)) {
            throw new WrongUsernameException(
                "Value {$value} provided for Username is not valid!!!"
            );
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}
