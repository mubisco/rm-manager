<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Event;

use App\Shared\Domain\Event\LastEventStore;
use Doctrine\DBAL\Connection;

final class DbalLastEventStore implements LastEventStore
{
    public function __construct(private Connection $connection)
    {
    }

    public function getLastEventIdProcessed(): int
    {
        $sql = "SELECT last_event FROM last_event_processed WHERE counter_id = 1";
        $results = $this->connection->fetchAllAssociative($sql);
        if (empty($results)) {
            return 0;
        }
        return (int) $results[0]['last_event'];
    }

    public function updateLastEventIdProcessed(int $eventId): void
    {
        $this->connection->update('last_event_processed', ['last_event' => $eventId], ['counter_id' => 1]);
    }
}
