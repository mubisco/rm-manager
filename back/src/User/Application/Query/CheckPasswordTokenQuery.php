<?php

declare(strict_types=1);

namespace App\User\Application\Query;

final class CheckPasswordTokenQuery
{
    public function __construct(private string $token)
    {
    }
    public function token(): string
    {
        return $this->token;
    }
}
