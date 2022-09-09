<?php

declare(strict_types=1);

namespace App\User\Domain;

use App\Shared\Domain\Event\DomainEvent;
use DateTimeImmutable;

final class UserWasCreated implements DomainEvent
{
    private DateTimeImmutable $occurredOn;

    public function __construct(
        public readonly string $userId,
        public readonly string $name,
        public readonly string $mail
    ) {
        $this->occurredOn = new DateTimeImmutable();
    }
    public function __toString(): string
    {
        $data = [
            'userId' => $this->userId,
            'name' => $this->name,
            'mail' => $this->mail,
        ];
        return json_encode($data);
    }

    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
