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
            $command = $this->parseRequest($request);
            $this->commandHandler->__invoke($command);
            return new JsonResponse(['message' => 'OK'], 200);
        } catch (PasswordChangeException) {
            return new JsonResponse(['message' => 'Error changing password'], 500);
        }
    }

    private function parseRequest(Request $request): ChangePasswordCommand
    {
        $content = (array) json_decode($request->getContent(), true);
        $command = new ChangePasswordCommand(
            $this->ensureRequestValue($content, 'token'),
            $this->ensureRequestValue($content, 'password')
        );
        return $command;
    }

    private function ensureRequestValue(array $data, string $key): string
    {
        if (!isset($data[$key])) {
            return '';
        }
        return (string) $data[$key];
    }
}
