<?php

declare(strict_types=1);

namespace App\User\Application\Query;

use App\Shared\Application\QueryHandlerInterface;
use App\User\Domain\PasswordTokenNotFoundException;

class CheckPasswordTokenQueryHandler implements QueryHandlerInterface
{
    public function __invoke(CheckPasswordTokenQuery $query): void
    {
        throw new PasswordTokenNotFoundException();
    }
}
