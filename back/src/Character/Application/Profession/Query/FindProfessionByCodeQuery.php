<?php

declare(strict_types=1);

namespace App\Character\Application\Profession\Query;

final class FindProfessionByCodeQuery
{
    public function __construct(
        public readonly string $lang,
        public readonly string $professionCode
    ) {
    }
}
