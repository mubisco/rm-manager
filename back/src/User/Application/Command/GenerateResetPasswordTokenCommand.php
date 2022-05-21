<?php

declare(strict_types=1);

namespace App\User\Application\Command;

final class GenerateResetPasswordTokenCommand
{
    public function __construct(private string $username)
    {
    }

    public function username(): string
    {
        return $this->username;
    }
}
