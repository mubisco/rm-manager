<?php

namespace App\Shared\Domain\Event;

interface LastEventStore
{
    public function getLastEventIdProcessed(): int;
    public function updateLastEventIdProcessed(int $eventId): void;
}
