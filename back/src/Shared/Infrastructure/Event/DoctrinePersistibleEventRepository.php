<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Event;

use App\Shared\Domain\Event\PersistibleEvent;
use App\Shared\Domain\Event\PersistibleEventId;
use App\Shared\Domain\Event\PersistibleEventNotFoundException;
use App\Shared\Domain\Event\PersistibleEventRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;

/** @extends ServiceEntityRepository<PersistibleEvent> */
final class DoctrinePersistibleEventRepository extends ServiceEntityRepository implements PersistibleEventRepository
{
    private ObjectManager $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersistibleEvent::class);
        $this->entityManager = $registry->getManager();
    }

    public function store(PersistibleEvent $event): PersistibleEvent
    {
        $this->entityManager->persist($event);
        $this->entityManager->flush();
        return $event;
    }

    public function ofId(PersistibleEventId $eventId): PersistibleEvent
    {
        try {
            $qb = $this->createQueryBuilder('pe');
            $qb->where('pe.eventId = :eventId');
            $qb->setParameter('eventId', $eventId->value());
            /** @var PersistibleEvent */
            return $qb->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            throw new PersistibleEventNotFoundException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
