<?php

namespace App\Shared\Domain\Event;

use DateTimeImmutable;
use Stringable;

interface DomainEvent extends Stringable
{
    public function occurredOn(): DateTimeImmutable;
}
