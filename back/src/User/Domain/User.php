<?php

namespace App\User\Domain;

interface User
{
    public function userId(): string;
    public function user(): string;
    public function role(): string;
    public function token(): string;
}
