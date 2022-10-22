<?php

declare(strict_types=1);

namespace App\User\Domain;

use InvalidArgumentException;

final class PasswordToken
{
    private string $token;
    private const SECRET = '11BBB9924C3D9E4EB354417F4D2DF';
    private const RANDOM_STRING_LENGTH = 25;
    private const ALLOWED_CHARACTERS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    private const VALIDATION_REGEX = '/[0-9a-z]{64}/';

    public static function fromEmpty(): self
    {
        $randomString = '';
        for ($i = 0; $i < self::RANDOM_STRING_LENGTH; $i++) {
            $index = rand(0, strlen(self::ALLOWED_CHARACTERS) - 1);
            $randomString .= self::ALLOWED_CHARACTERS[$index];
        }
        $hashedToken = hash_hmac("sha256", $randomString, self::SECRET, false);
        return new self($hashedToken);
    }

    public static function fromString(string $token): self
    {
        return new self($token);
    }

    private function __construct(string $token)
    {
        if (!preg_match(self::VALIDATION_REGEX, $token)) {
            throw new InvalidArgumentException('Provided PasswordToken not valid');
        }
        $this->token = $token;
    }

    public function value(): string
    {
        return $this->token;
    }
}
