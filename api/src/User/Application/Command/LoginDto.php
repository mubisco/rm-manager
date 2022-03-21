<?php

namespace App\User\Application\Command;

final class LoginDto
{
    public function __construct(
        public string $user,
        public string $role,
        public string $token
    ) {
    }
}
