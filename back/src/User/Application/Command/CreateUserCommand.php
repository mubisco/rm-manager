<?php

declare(strict_types=1);

namespace App\User\Application\Command;

final class CreateUserCommand
{
    public function __construct(public readonly array $data)
    {
    }
}
