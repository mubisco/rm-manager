<?php

namespace App\User\Domain;

interface WelcomeUserMailer
{
    public function sendWelcomeMail(Username $username, UserEmail $userEmail): bool;
}
