<?php

namespace App\User\Domain;

use App\Shared\Domain\Event\DomainEvent;

interface User
{
    public function userId(): UserId;
    public function user(): string;
    public function generateResetPasswordToken(): string;
    public function isTokenExpired(): bool;
    public function mail(): string;
    public function passwordResetToken(): string;
    /** @return DomainEvent[] */
    public function pullEvents(): array;
}
