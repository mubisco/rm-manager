<?php

namespace App\Shared\Domain\Event;

trait EventAware
{
    /** @var DomainEvent[] */
    private array $events = [];

    /**
     * @return DomainEvent[]
     */
    public function pullEvents(): array
    {
        $events = $this->events;
        $this->events = [];
        return $events;
    }

    private function addEvent(DomainEvent $event): void
    {
        $this->events[] = $event;
    }
}
