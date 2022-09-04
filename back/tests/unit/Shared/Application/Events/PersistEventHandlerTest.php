<?php

namespace App\Tests\unit\Shared\Application\Events;

use App\Shared\Application\Events\PersistEventHandler;
use App\Shared\Domain\Event\DomainEvent;
use App\Shared\Domain\Event\PersistibleEventRepository;
use App\Shared\Domain\Event\PersistibleEventRepositoryException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class PersistEventHandlerTest extends TestCase
{
    private PersistEventHandler $sut;
    private PersistibleEventRepository|MockObject $eventRepository;
    private DomainEvent|MockObject $domainEvent;

    protected function setUp(): void
    {
        $this->eventRepository = $this->createMock(PersistibleEventRepository::class);
        $this->domainEvent = $this->createMock(DomainEvent::class);
        $this->sut = new PersistEventHandler($this->eventRepository);
    }
    /**
     * @test
     */
    public function itShouldBeOfProperClass(): void
    {
        $this->assertInstanceOf(PersistEventHandler::class, $this->sut);
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionIfRepositoryFails(): void
    {
        $this->expectException(PersistibleEventRepositoryException::class);
        $this->eventRepository
             ->method('store')
             ->willThrowException(new PersistibleEventRepositoryException());
        ($this->sut)($this->domainEvent);
    }

    /**
     * @test
     */
    public function itShouldStoreEventProperly(): void
    {
        $this->eventRepository
             ->expects($this->once())
             ->method('store')
             ->willReturnArgument(0);
        ($this->sut)($this->domainEvent);
        $this->assertTrue(true);
    }
}
