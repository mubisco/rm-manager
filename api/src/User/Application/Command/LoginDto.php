<?php

namespace App\User\Application\Command;

use App\User\Domain\User;

final class LoginDto
{
    public static function fromUser(User $user): self
    {
        return new self(
            $user->user(),
            $user->role(),
            $user->token()
        );
    }
    public function __construct(
        public string $user,
        public string $role,
        public string $token
    ) {
    }
}
