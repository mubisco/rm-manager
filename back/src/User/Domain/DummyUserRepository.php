<?php

declare(strict_types=1);

namespace App\User\Domain;

final class DummyUserRepository implements UserRepository
{
    public function byUsername(Username $username): User
    {
        throw new \RuntimeException(sprintf('Not intended for use %s', __METHOD__));
    }

    public function update(User $user): User
    {
        throw new \RuntimeException(sprintf('Not intended for use %s', __METHOD__));
    }
}
