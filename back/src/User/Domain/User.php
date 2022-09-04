<?php

namespace App\User\Domain;

interface User
{
    public function userId(): UserId;
    public function user(): string;
    public function generateResetPasswordToken(): string;
    public function mail(): string;
    public function passwordResetToken(): string;
}
