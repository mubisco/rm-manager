<?php

declare(strict_types=1);

namespace App\User\Application\Query;

use App\Shared\Application\QueryHandlerInterface;
use App\User\Domain\PasswordToken;
use App\User\Domain\PasswordTokenExpiredException;
use App\User\Domain\PasswordTokenNotFoundException;
use App\User\Domain\UserRepository;
use InvalidArgumentException;

class CheckPasswordTokenQueryHandler implements QueryHandlerInterface
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    /**
     * @throws InvalidArgumentException If token has invalid format
     * @throws PasswordTokenNotFoundException If password token does not exists
     * @throws PasswordTokenExpiredException If password token is expired
     */
    public function __invoke(CheckPasswordTokenQuery $query): bool
    {
        $token = PasswordToken::fromString($query->token());
        $this->userRepository->ofValidPasswordToken($token);
        return true;
    }
}
