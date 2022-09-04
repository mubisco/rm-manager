<?php

declare(strict_types=1);

namespace App\Shared\Domain\Event;

use DateTimeImmutable;

final class StoredEvent implements DomainEvent
{
    private ?int $eventId = null;

    public function __construct(
        private string $typeName,
        private DateTimeImmutable $occurredOn,
        private string $eventBody
    ) {
    }
    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }

    public function typeName(): string
    {
        return $this->typeName;
    }

    public function eventBody(): string
    {
        return $this->eventBody;
    }
    public function eventId(): int
    {
        return $this->eventId ?? 0;
    }

    public function __toString(): string
    {
    }
}
