<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Encryptor;

use App\User\Domain\PasswordEncryptor;
use App\User\Domain\PasswordEncryptorException;
use App\User\Domain\User;
use App\User\Domain\UserPassword;
use App\User\Infrastructure\Persistence\Doctrine\DoctrineUser;
use Symfony\Component\PasswordHasher\Exception\InvalidPasswordException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class BcryptPasswordEncryptor implements PasswordEncryptor
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function encryptPassword(User $user, UserPassword $userPassword): string
    {
        try {
            /** @var DoctrineUser */
            $doctrineUser = $user;
            return $this->hasher->hashPassword($doctrineUser, $userPassword->value());
        } catch (InvalidPasswordException $e) {
            throw new PasswordEncryptorException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
