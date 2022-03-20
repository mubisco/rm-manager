<?php

namespace App\Ready\Infrastructure\EntryPoint\Api;

use Symfony\Component\HttpFoundation\JsonResponse;

class ReadyController
{
    public function index(): JsonResponse
    {
        return new JsonResponse(['ready' => true], 200);
    }
}
