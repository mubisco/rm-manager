<?php

namespace App\Shared\Domain\Event;

use BadMethodCallException;
use PHPUnit\Framework\TestCase;

class DomainEventPublisherTest extends TestCase implements DomainEventSubscriber
{
    private int $counter;
    private DomainEventPublisher $sut;
    protected function setUp(): void
    {
        $this->counter = 0;
        $this->sut = DomainEventPublisher::instance();
    }
    public function testShouldBeOfProperClass(): void
    {
        $this->assertInstanceOf(DomainEventPublisher::class, $this->sut);
    }

    public function testShouldReturnInstanceFromNamedConstructor(): void
    {
        $this->assertInstanceOf(DomainEventPublisher::class, $this->sut);
    }

    public function testShouldThrowExceptionOnClone(): void
    {
        $this->expectException(BadMethodCallException::class);
        clone $this->sut;
    }

    public function testShouldNotBeHandledIfNoSubscriber(): void
    {
        $event = $this->createMock(DomainEvent::class);
        $this->sut->publish($event);
        $this->assertEquals($this->counter, 0);
    }

    public function testShouldBeHandledIfNoSubscriber(): void
    {
        $event = $this->createMock(DomainEvent::class);
        $this->sut->subscribe($this);
        $this->sut->publish($event);
        $this->assertEquals($this->counter, 1);
    }

    public function handle(DomainEvent $domainEvent): void
    {
        $this->counter++;
    }

    public function isSubscribedTo(DomainEvent $domainEvent): bool
    {
        return true;
    }
}
