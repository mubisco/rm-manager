<?php

declare(strict_types=1);

namespace App\Character\Infrastructure\EntryPoint\Api;

use App\Shared\Infrastructure\ControllerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ProfessionController implements ControllerInterface
{
    public function getByCode(string $professionCode): JsonResponse
    {
        return new JsonResponse([], Response::HTTP_OK);
    }
}
