<?php

declare(strict_types=1);

namespace App\User\Infrastructure\EntryPoint\Api;

use App\Shared\Infrastructure\ControllerInterface;
use App\User\Application\Command\GenerateResetPasswordTokenCommand;
use App\User\Application\Command\GenerateResetPasswordTokenCommandHandler;
use App\User\Domain\PasswordNotReseteableException;
use App\User\Domain\UserNotFoundException;
use App\User\Domain\UserRepositoryException;
use App\User\Domain\WrongUsernameException;
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
        } catch (WrongUsernameException) {
            return $this->createResponse('WRONG_USERNAME', Response::HTTP_BAD_REQUEST);
        } catch (UserNotFoundException) {
            return $this->createResponse('USER_NOT_FOUND', Response::HTTP_NOT_FOUND);
        } catch (PasswordNotReseteableException) {
            return $this->createResponse('INTERNAL_ERROR', Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (UserRepositoryException) {
            return $this->createResponse('INTERNAL_ERROR', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->createResponse('PASSWORD_RESET_OK', Response::HTTP_OK);
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

    private function createResponse(string $message, int $statusCode): JsonResponse
    {
        return new JsonResponse(['message' => $message], $statusCode);
    }
}
