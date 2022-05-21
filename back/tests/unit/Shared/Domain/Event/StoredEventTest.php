<?php

namespace App\Shared\Domain\Event;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class StoredEventTest extends TestCase
{
    public function testShouldBeOfProperClass(): void
    {
        $sut = new StoredEvent(
            'SomeClassName',
            new DateTimeImmutable(),
            ''
        );
        $this->assertInstanceOf(StoredEvent::class, $sut);
        $this->assertInstanceOf(DomainEvent::class, $sut);
    }

    public function testShouldReturnProperOccurredOnDate(): void
    {
        $now = new DateTimeImmutable();
        $sut = new StoredEvent(
            'SomeClassName',
            $now,
            '["some", "serialized", "string"]'
        );
        $this->assertEquals('SomeClassName', $sut->typeName());
        $this->assertEquals($now->format('Y-m-d H:i:s'), $sut->occurredOn()->format('Y-m-d H:i:s'));
        $this->assertEquals('["some", "serialized", "string"]', $sut->eventBody());
        $this->assertEquals(0, $sut->eventId());
    }
}
