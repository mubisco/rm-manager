<?php

namespace App\User\Domain;

interface UserFactory
{
    public function make(array $data): User;
}
