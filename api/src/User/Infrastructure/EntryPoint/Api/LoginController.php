<?php

namespace App\User\Infrastructure\EntryPoint\Api;

use App\Shared\Infrastructure\ControllerInterface;
use App\User\Application\Command\LoginCommand;
use App\User\Domain\UnauthorizedUserException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;

final class LoginController implements ControllerInterface
{
    public MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }
    public function login(Request $request): JsonResponse
    {
        try {
            $requestData = (array) json_decode($request->getContent(), true);
            $command = new LoginCommand(
                (string) $requestData['email'],
                (string) $requestData['password']
            );
            $result = $this->commandBus->dispatch($command);
            $response = $result->getMessage();
            return new JsonResponse($response, 200);
        } catch (UnauthorizedUserException) {
            return new JsonResponse(['message' => 'UNAUTHORIZED_USER'], 403);
        }
    }
}
