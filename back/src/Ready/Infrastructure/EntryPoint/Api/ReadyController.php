<?php

namespace App\Ready\Infrastructure\EntryPoint\Api;

use App\Shared\Infrastructure\ControllerInterface;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ReadyController implements ControllerInterface
{
    #[OA\Response(
        response: 200,
        description: 'Returns the status of general API',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: "ready", type: "bool")
            ]
        )
    )]
    #[OA\Tag(name: 'test-endpoints')]
    public function index(): JsonResponse
    {
        return new JsonResponse(['ready' => true], 200);
    }

    #[OA\Response(
        response: 200,
        description: 'Returns the status of admin API',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: "admin", type: "bool")
            ]
        )
    )]
    #[OA\Tag(name: 'test-endpoints')]
    public function admin(): JsonResponse
    {
        return new JsonResponse(['admin' => true], 200);
    }

    #[OA\Response(
        response: 200,
        description: 'Returns the status of masters API',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: "master", type: "bool")
            ]
        )
    )]
    #[OA\Tag(name: 'test-endpoints')]
    public function master(): JsonResponse
    {
        return new JsonResponse(['master' => true], 200);
    }

    #[OA\Response(
        response: 200,
        description: 'Returns the status of players API',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: "player", type: "bool")
            ]
        )
    )]
    #[OA\Tag(name: 'test-endpoints')]
    public function player(): JsonResponse
    {
        return new JsonResponse(['player' => true], 200);
    }
}
