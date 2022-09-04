<?php

declare(strict_types=1);

namespace App\Tests\unit\User\Application\Command;

use App\Shared\Domain\Event\EventBus;

final class SpyEventBus implements EventBus
{
    public array $events = [];

    public function sendEvents(array $events): void
    {
        $this->events = $events;
    }
}
