<?php

declare(strict_types=1);

namespace App\Shared\Domain\Event;

use DateTimeImmutable;

final class PersistibleEvent implements DomainEvent
{
    private string $eventId;

    public static function fromDomainEvent(DomainEvent $event): self
    {
        return new self(
            (string) $event,
            $event->occurredOn()
        );
    }

    private function __construct(
        private string $body,
        private DateTimeImmutable $ocurredOn
    ) {
        $this->eventId = PersistibleEventId::fromEmpty()->value();
    }

    public function eventId(): PersistibleEventId
    {
        return PersistibleEventId::fromString($this->eventId);
    }

    public function __toString(): string
    {
        return $this->body;
    }

    public function occurredOn(): DateTimeImmutable
    {
        return $this->ocurredOn;
    }
}
