<?php

namespace App\Shared\Domain\Event;

interface PersistibleEventRepository
{
    /**
     * @throws PersistibleEventRepositoryException
     */
    public function store(PersistibleEvent $event): PersistibleEvent;
    /**
     * @throws PersistibleEventNotFoundException
     */
    public function ofId(PersistibleEventId $eventId): PersistibleEvent;
}
