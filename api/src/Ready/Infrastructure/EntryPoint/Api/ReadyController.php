<?php

namespace App\Ready\Infrastructure\EntryPoint\Api;

use App\Shared\Infrastructure\ControllerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ReadyController implements ControllerInterface
{
    public function index(): JsonResponse
    {
        return new JsonResponse(['ready' => true], 200);
    }
}
