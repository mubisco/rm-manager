<?php

declare(strict_types=1);

namespace App\User\Infrastructure\EntryPoint\Api;

use App\Shared\Infrastructure\ControllerInterface;
use App\User\Application\Command\GenerateResetPasswordTokenCommand;
use App\User\Application\Command\GenerateResetPasswordTokenCommandHandler;
use App\User\Domain\UserNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class UserApiController implements ControllerInterface
{
    public function __construct(
        private GenerateResetPasswordTokenCommandHandler $generateResetPasswordTokenCommandHandler
    ) {
    }
    public function resetPassword(Request $request): JsonResponse
    {
        $userName = $this->filterRequest($request);
        $command = new GenerateResetPasswordTokenCommand($userName);
        try {
            ($this->generateResetPasswordTokenCommandHandler)($command);
        } catch (UserNotFoundException) {
            return new JsonResponse(['message' => 'USER_NOT_FOUND'], Response::HTTP_NOT_FOUND);
        }
        return new JsonResponse(['message' => 'PASSWORD_RESET_OK'], Response::HTTP_OK);
        /*
        $username = $this->filterRequest($request);
        if (!$username) {
            return new JsonResponse(['message' => 'NO_USER'], Response::HTTP_BAD_REQUEST);
        }
        if ($username == 'nonExistantUser') {
            return new JsonResponse(['message' => 'USER_NOT_FOUND'], Response::HTTP_NOT_FOUND);
        }
         */
    }

    private function filterRequest(Request $request): string
    {
        $rawContent = $request->getContent();
        /** @var array */
        $content = json_decode($rawContent, true);
        /** @var string */
        $username = $content['username'] ?? '';
        return $username;
    }
}
