<?php

declare(strict_types=1);

namespace App\Character\Application\Profession\Query;

class FindProfessionByCodeQueryHandler
{
    public function __invoke(FindProfessionByCodeQuery $query): array
    {
        throw new \RuntimeException(sprintf('Implement %s', __METHOD__));
    }
}
