<?php

namespace App\User\Domain;

interface UserRepository
{
    // public function login(UserEmail $userEmail, UserPassword $userPassword): User;
    public function byUsername(Username $username): User;
    public function update(User $user): User;
}
