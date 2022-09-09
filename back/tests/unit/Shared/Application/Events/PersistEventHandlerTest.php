<?php

namespace App\Tests\unit\Shared\Application\Events;

use App\Shared\Application\Events\PersistEventHandler;
use App\Shared\Domain\Event\PersistibleEvent;
use App\Shared\Domain\Event\PersistibleEventRepository;
use App\Shared\Domain\Event\PersistibleEventRepositoryException;
use App\User\Domain\PasswordTokenWasRequested;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class PersistEventHandlerTest extends TestCase
{
    private PersistEventHandler $sut;
    private PersistibleEventRepository|MockObject $eventRepository;
    private PersistibleEvent $event;

    protected function setUp(): void
    {
        $this->eventRepository = $this->createMock(PersistibleEventRepository::class);
        $this->event = PersistibleEvent::fromDomainEvent(new PasswordTokenWasRequested('userId'));
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
        ($this->sut)($this->event);
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
        ($this->sut)($this->event);
        $this->assertTrue(true);
    }
}
