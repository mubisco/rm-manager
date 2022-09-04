<?php

namespace App\Tests\unit\Shared\Domain\Event;

use App\Shared\Domain\Event\PersistibleEvent;
use App\Shared\Domain\Event\PersistibleEventId;
use App\User\Domain\PasswordTokenWasRequested;
use PHPUnit\Framework\TestCase;

class PersistibleEventTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldReturnProperEventId(): void
    {
        $domainEvent = new PasswordTokenWasRequested('474f2052-c3aa-4b51-81e8-aee2b2c67223');
        $sut = PersistibleEvent::fromDomainEvent($domainEvent);
        $this->assertInstanceOf(PersistibleEventId::class, $sut->eventId());
        $this->assertEquals((string) $domainEvent, $sut->__toString());
        $this->assertEquals($domainEvent->occurredOn(), $sut->occurredOn());
    }
}
