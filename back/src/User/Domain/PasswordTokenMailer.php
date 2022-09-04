<?php

namespace App\User\Domain;

interface PasswordTokenMailer
{
    public function send(string $username, string $mailer, string $token): bool;
}
