<?php

namespace App\User\Infrastructure\EntryPoint\Api;

use App\Shared\Infrastructure\ControllerInterface;
use App\User\Application\Command\LoginCommand;
use App\User\Application\Command\LoginDto;
use App\User\Domain\UnauthorizedUserException;
use App\User\Domain\WrongUserEmailException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class LoginController implements ControllerInterface
{
    public function __construct(
        private MessageBusInterface $commandBus
    ) {
    }
    public function login(Request $request): JsonResponse
    {
        try {
            $requestData = (array) json_decode($request->getContent(), true);
            $command = new LoginCommand(
                (string) $requestData['email'],
                (string) $requestData['password']
            );
            $envelope = $this->commandBus->dispatch($command);
            /** @var HandledStamp */
            $handledStamp = $envelope->last(HandledStamp::class);
            /** @var LoginDto */
            $data = $handledStamp->getResult();
            return new JsonResponse($data, 200);
        } catch (UnauthorizedUserException) {
            return new JsonResponse(['message' => 'UNAUTHORIZED_USER'], 403);
        } catch (WrongUserEmailException) {
            return new JsonResponse(['message' => 'BAD_PARAMS'], 400);
        }
    }
}
