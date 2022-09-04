<?php

namespace App\User\Domain;

interface UserRepository
{
    public function byUsername(Username $username): User;
    public function ofId(UserId $userId): User;
    public function update(User $user): User;
}
