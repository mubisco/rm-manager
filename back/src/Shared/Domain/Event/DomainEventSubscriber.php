<?php

namespace App\Shared\Domain\Event;

interface DomainEventSubscriber
{
    public function handle(DomainEvent $domainEvent): void;
    public function isSubscribedTo(DomainEvent $domainEvent): bool;
}
