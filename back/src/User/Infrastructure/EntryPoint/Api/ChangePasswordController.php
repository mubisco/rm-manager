<?php

declare(strict_types=1);

namespace App\User\Infrastructure\EntryPoint\Api;

use App\Shared\Infrastructure\ControllerInterface;
use App\User\Application\Command\ChangePasswordCommand;
use App\User\Application\Command\ChangePasswordCommandHandler;
use App\User\Domain\PasswordChangeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class ChangePasswordController extends AbstractController implements ControllerInterface
{
    public function __construct(private ChangePasswordCommandHandler $commandHandler)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $content = json_decode($request->getContent(), true);

            $command = new ChangePasswordCommand(
                $content['token'] ?? '',
                $content['password'] ?? ''
            );
            $this->commandHandler->__invoke($command);
        } catch (PasswordChangeException) {
            return new JsonResponse(['message' => 'Error changing password'], 500);
        }
        return new JsonResponse(['message' => 'OK'], 200);
    }
}
