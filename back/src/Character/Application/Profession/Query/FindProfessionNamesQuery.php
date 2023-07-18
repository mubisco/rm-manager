<?php

declare(strict_types=1);

namespace App\Character\Application\Profession\Query;

final class FindProfessionNamesQuery
{
    public function __construct(public readonly string $lang)
    {
    }
}
