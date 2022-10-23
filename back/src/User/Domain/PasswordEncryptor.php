<?php

namespace App\User\Domain;

interface PasswordEncryptor
{
    public function encryptPassword(User $user, UserPassword $userPassword): string;
}
