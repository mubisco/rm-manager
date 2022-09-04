<?php

namespace App\Shared\Domain\Event;

interface EventBus
{
    /**
     * @param DomainEvent[] $events
     */
    public function sendEvents(array $events): void;
}
