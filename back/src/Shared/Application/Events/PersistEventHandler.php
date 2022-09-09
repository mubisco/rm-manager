<?php

declare(strict_types=1);

namespace App\Shared\Application\Events;

use App\Shared\Application\EventSyncHandlerInterface;
use App\Shared\Domain\Event\PersistibleEvent;
use App\Shared\Domain\Event\PersistibleEventRepository;
use App\Shared\Domain\Event\PersistibleEventRepositoryException;

final class PersistEventHandler implements EventSyncHandlerInterface
{
    public function __construct(private PersistibleEventRepository $persistibleEventRepository)
    {
    }

    /**
     * @throws PersistibleEventRepositoryException
     */
    public function __invoke(PersistibleEvent $event): void
    {
        $this->persistibleEventRepository->store($event);
    }
}
