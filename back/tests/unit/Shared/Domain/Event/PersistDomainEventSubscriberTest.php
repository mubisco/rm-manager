<?php

namespace App\Shared\Domain\Event;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class PersistDomainEventSubscriberTest extends TestCase
{
    private PersistDomainEventSubscriber $sut;
    private MockObject|EventStore $eventStore;
    protected function setUp(): void
    {
        $this->eventStore = $this->createMock(EventStore::class);
        $this->sut = new PersistDomainEventSubscriber($this->eventStore);
    }

    public function testShouldBeOfProperClass(): void
    {
        $this->assertInstanceOf(PersistDomainEventSubscriber::class, $this->sut);
        $this->assertInstanceOf(DomainEventSubscriber::class, $this->sut);
    }

    public function testShouldReturnTrueOnIsSubscribedTo(): void
    {
        $event = $this->createMock(DomainEvent::class);
        $result = $this->sut->isSubscribedTo($event);
        $this->assertTrue($result);
    }

    public function testShouldStoreEventWhenHandled(): void
    {
        $event = $this->createMock(DomainEvent::class);
        $this->eventStore->expects($this->once())->method('append');
        $this->sut->handle($event);
    }
}
