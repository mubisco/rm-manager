<?php

declare(strict_types=1);

namespace App\Symfony\Infrastructure\Event;

use App\Shared\Domain\Event\DomainEvent;
use App\Shared\Domain\Event\EventBus;
use InvalidArgumentException;
use Symfony\Component\Messenger\MessageBusInterface;

final class SymfonyEventBus implements EventBus
{
    public function __construct(
        private MessageBusInterface $eventAsyncBus
    ) {
    }
    public function sendEvents(array $events): void
    {
        foreach ($events as $event) {
            $this->validateEvent($event);
            $this->eventAsyncBus->dispatch($event);
        }
    }

    private function validateEvent(mixed $event): void
    {
        if (!is_a($event, DomainEvent::class)) {
            throw new InvalidArgumentException('Only DomainEvents allowed for this EventBus!!!');
        }
    }
}
