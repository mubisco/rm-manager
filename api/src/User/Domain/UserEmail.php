<?php

namespace App\User\Domain;

class UserEmail
{
    public string $value;

    public function __construct(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new WrongUserEmailException("{$value} is not a valid Email!!!");
        }
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
