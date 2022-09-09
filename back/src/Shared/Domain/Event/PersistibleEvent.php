<?php

declare(strict_types=1);

namespace App\Shared\Domain\Event;

use DateTimeImmutable;

final class PersistibleEvent
{
    private string $eventId;

    public static function fromDomainEvent(DomainEvent $event): self
    {
        return new self(
            (string) $event,
            get_class($event),
            $event->occurredOn()
        );
    }

    private function __construct(
        private string $body,
        private string $eventType,
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

    public function type(): string
    {
        return $this->eventType;
    }
}
