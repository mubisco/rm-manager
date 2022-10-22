<?php

declare(strict_types=1);

namespace App\User\Infrastructure\EntryPoint\Api;

use App\Shared\Infrastructure\ControllerInterface;
use App\User\Application\Query\CheckPasswordTokenQuery;
use App\User\Application\Query\CheckPasswordTokenQueryHandler;
use App\User\Domain\PasswordTokenExpiredException;
use App\User\Domain\PasswordTokenNotFoundException;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CheckPasswordTokenController implements ControllerInterface
{
    public function __construct(private CheckPasswordTokenQueryHandler $queryHandler)
    {
    }

    public function __invoke(string $token): JsonResponse
    {
        $query = new CheckPasswordTokenQuery($token);
        try {
            ($this->queryHandler)($query);
        } catch (PasswordTokenNotFoundException | InvalidArgumentException) {
            return new JsonResponse(['message' => 'NOT_FOUND'], Response::HTTP_NOT_FOUND);
        } catch (PasswordTokenExpiredException) {
            return new JsonResponse(['message' => 'EXPIRED'], Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse(['message' => 'OK'], 200);
    }
}
