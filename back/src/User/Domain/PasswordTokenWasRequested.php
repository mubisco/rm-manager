<?php

declare(strict_types=1);

namespace App\User\Domain;

use App\Shared\Domain\Event\DomainEvent;
use DateTimeImmutable;

final class PasswordTokenWasRequested implements DomainEvent
{
    private DateTimeImmutable $occurredOn;
    public function __construct(
        private string $userId,
    ) {
        $this->occurredOn = new DateTimeImmutable();
    }
    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }
    public function userId(): string
    {
        return $this->userId;
    }

    public function __toString(): string
    {
        return json_encode([
            'userId' => $this->userId
        ]);
    }
}
