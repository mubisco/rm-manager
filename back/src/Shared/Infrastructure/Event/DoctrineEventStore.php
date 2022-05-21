<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Event;

use App\Shared\Domain\Event\DomainEvent;
use App\Shared\Domain\Event\EventStore;
use App\Shared\Domain\Event\StoredEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use JMS\Serializer\SerializerInterface;

final class DoctrineEventStore extends ServiceEntityRepository implements EventStore
{
    public function __construct(
        private ManagerRegistry $registry,
        private SerializerInterface $serializer
    ) {
        parent::__construct($registry, StoredEvent::class);
    }

    public function append(DomainEvent $domainEvent): void
    {
        $storedEvent = $this->createStoredEvent($domainEvent);
        $this->_em->persist($storedEvent);
        $this->_em->flush();
    }

    public function allStoredEventsSince(?int $eventId = null): array
    {
        $query = $this->createQueryBuilder('e');
        if ($eventId) {
            $query->where('e.eventId > :eventId');
            $query->setParameter('eventId', $eventId);
        }
        $query->orderBy('e.eventId');
        /** @var StoredEvent[] */
        return $query->getQuery()->getResult();
    }

    private function createStoredEvent(DomainEvent $domainEvent): StoredEvent
    {
        return new StoredEvent(
            get_class($domainEvent),
            $domainEvent->occurredOn(),
            $this->serializer->serialize($domainEvent, 'json')
        );
    }
}
