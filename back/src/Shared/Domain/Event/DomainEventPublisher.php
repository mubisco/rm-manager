<?php

declare(strict_types=1);

namespace App\Shared\Domain\Event;

use BadMethodCallException;

final class DomainEventPublisher
{
    private static ?DomainEventPublisher $instance = null;
    /** @var DomainEventSubscriber[] */
    private array $subscribers;

    public static function instance(): self
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function __construct()
    {
        $this->subscribers = [];
    }

    public function __clone()
    {
        throw new BadMethodCallException('DomainEventPublisher cannot be cloned!!!');
    }

    public function subscribe(DomainEventSubscriber $subscriber): void
    {
        $this->subscribers[] = $subscriber;
    }

    public function publish(DomainEvent $domainEvent): void
    {
        foreach ($this->subscribers as $subscriber) {
            if ($subscriber->isSubscribedTo($domainEvent)) {
                $subscriber->handle($domainEvent);
            }
        }
    }
}
