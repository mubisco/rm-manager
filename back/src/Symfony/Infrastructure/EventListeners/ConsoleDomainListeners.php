<?php

declare(strict_types=1);

namespace App\Symfony\Infrastructure\EventListeners;

use App\Shared\Domain\Event\DomainEventPublisher;
use App\Shared\Domain\Event\DomainEventSubscriber;

final class ConsoleDomainListeners
{
    public function __construct(private array $subscribers)
    {
    }

    public function onConsoleCommand(): void
    {
        $publisher = DomainEventPublisher::instance();
        /** @var DomainEventSubscriber */
        foreach ($this->subscribers as $subscriber) {
            $publisher->subscribe($subscriber);
        }
    }
}
