<?php

declare(strict_types=1);

namespace App\Shared\Application\Events;

use App\Shared\Domain\Event\DomainEvent;
use App\Shared\Domain\Event\PersistibleEvent;
use App\Shared\Domain\Event\PersistibleEventRepository;
use App\Shared\Domain\Event\PersistibleEventRepositoryException;

final class PersistEventHandler
{
    public function __construct(private PersistibleEventRepository $persistibleEventRepository)
    {
    }

    /**
     * @throws PersistibleEventRepositoryException
     */
    public function __invoke(DomainEvent $domainEvent): void
    {
        $this->persistibleEventRepository->store(
            PersistibleEvent::fromDomainEvent($domainEvent)
        );
    }
}
