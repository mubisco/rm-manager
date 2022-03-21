<?php

namespace App\User\Domain;

class UserPassword
{
    public string $value;

    public function __construct(string $value)
    {
        if ($value === 'wrongPassword') {
            throw new WrongPasswordFormatException('Password has wrong format');
        }
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
