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

    public function admin(): JsonResponse
    {
        return new JsonResponse(['admin' => true], 200);
    }

    public function master(): JsonResponse
    {
        return new JsonResponse(['master' => true], 200);
    }

    public function player(): JsonResponse
    {
        return new JsonResponse(['player' => true], 200);
    }
}
