<?php

declare(strict_types=1);

namespace App\User\Application\Command;

final class ChangeUserPasswordCommand
{
    public function __construct(
        public readonly string $username,
        public readonly string $newPassword
    ) {
    }
}
