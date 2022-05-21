<?php

declare(strict_types=1);

namespace App\Shared\Domain\Event;

final class PersistDomainEventSubscriber implements DomainEventSubscriber
{
    public function __construct(private EventStore $eventStore)
    {
    }

    public function handle(DomainEvent $domainEvent): void
    {
        $this->eventStore->append($domainEvent);
    }

    public function isSubscribedTo(DomainEvent $domainEvent): bool
    {
        return true;
    }
}
