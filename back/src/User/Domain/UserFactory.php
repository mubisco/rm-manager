<?php

namespace App\User\Domain;

interface UserFactory
{
    /**
     * @param array<array-key, mixed> $data
     */
    public function make(array $data): User;
}
