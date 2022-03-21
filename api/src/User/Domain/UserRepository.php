<?php

namespace App\User\Domain;

interface UserRepository
{
    public function login(UserEmail $userEmail, UserPassword $userPassword): User;
}
