<?php

declare(strict_types=1);

namespace App\Character\Infrastructure\EntryPoint\Api;

use App\Character\Application\Profession\Query\FindProfessionNamesQuery;
use App\Character\Application\Profession\Query\FindProfessionNamesQueryHandler;
use App\Character\Domain\Profession\ProfessionNamesReadException;
use App\Shared\Infrastructure\ControllerInterface;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ProfessionNamesController implements ControllerInterface
{
    public function __construct(
        private readonly FindProfessionNamesQueryHandler $queryHandler
    ) {
    }
    public function index(string $lang): JsonResponse
    {
        try {
            $result = ($this->queryHandler)(new FindProfessionNamesQuery($lang));
            return new JsonResponse($result, Response::HTTP_OK);
        } catch (InvalidArgumentException $e) {
            return new JsonResponse(
                ['message' => $e->getMessage()],
                Response::HTTP_BAD_REQUEST
            );
        } catch (ProfessionNamesReadException $e) {
            return new JsonResponse(
                ['message' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
