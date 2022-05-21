<?php

namespace App\Shared\Domain\Event;

interface EventStore
{
    public function append(DomainEvent $domainEvent): void;
    /** @return StoredEvent[] */
    public function allStoredEventsSince(?int $eventId = null): array;
}
