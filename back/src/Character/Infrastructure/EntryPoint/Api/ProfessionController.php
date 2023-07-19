<?php

declare(strict_types=1);

namespace App\Character\Infrastructure\EntryPoint\Api;

use App\Character\Application\Profession\Query\FindProfessionByCodeQuery;
use App\Character\Application\Profession\Query\FindProfessionByCodeQueryHandler;
use App\Character\Domain\Profession\ProfessionNotFoundException;
use App\Shared\Infrastructure\ControllerInterface;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ProfessionController implements ControllerInterface
{
    public function __construct(private readonly FindProfessionByCodeQueryHandler $queryHandler)
    {
    }

    public function getByCode(string $lang, string $professionCode): JsonResponse
    {
        try {
            $result = ($this->queryHandler)(new FindProfessionByCodeQuery($lang, $professionCode));
            return new JsonResponse($result, Response::HTTP_OK);
        } catch (InvalidArgumentException $e) {
            return new JsonResponse(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (ProfessionNotFoundException $e) {
            return new JsonResponse(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }
}
