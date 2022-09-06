<?php

declare(strict_types=1);

namespace App\User\Infrastructure\EntryPoint\Console;

use App\User\Domain\User;
use App\User\Domain\UserFactory;

final class DoctrineUserConsoleCommandFactory implements UserFactory
{
    public function make(array $data): User
    {
        throw new \RuntimeException(sprintf('Implement %s', __METHOD__));
    }
}
