<?php

namespace App\User\Domain;

class UserPassword
{
    private string $value;
    private const REGEX_PASSWORD = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/';

    public function __construct(string $value)
    {
        if (!preg_match(self::REGEX_PASSWORD, $value)) {
            throw new WrongPasswordFormatException('Password has wrong format');
        }
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
