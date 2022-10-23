<?php

declare(strict_types=1);

namespace App\User\Application\Command;

final class ChangePasswordCommand
{
    public function __construct(private string $token, private string $password)
    {
    }

    public function token(): string
    {
        return $this->token;
    }

    public function password(): string
    {
        return $this->password;
    }
}
