<?php

namespace App\Tests\unit\Symfony\Infrastructure\Event;

use App\Shared\Domain\Event\DomainEvent;
use App\Shared\Domain\Event\EventBus;
use App\Symfony\Infrastructure\Event\SymfonyEventBus;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class SymfonyEventBusTest extends TestCase
{
    private SymfonyEventBus $sut;
    private MessageBusInterface|MockObject $asyncBusInterface;
    private MessageBusInterface|MockObject $syncBusInterface;

    protected function setUp(): void
    {
        $this->asyncBusInterface = $this->createMock(MessageBusInterface::class);
        $this->syncBusInterface = $this->createMock(MessageBusInterface::class);
        $this->sut = new SymfonyEventBus($this->syncBusInterface, $this->asyncBusInterface);
    }
    /**
     * @test
     */
    public function itShouldBeOfProperClass(): void
    {
        $this->assertInstanceOf(SymfonyEventBus::class, $this->sut);
        $this->assertInstanceOf(EventBus::class, $this->sut);
    }

    /**
     * @test
     */
    public function itShouldThrowInvalidArgumentException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->sut->sendEvents(['asd']);
    }

    /**
     * @test
     */
    public function itShouldSendEventsThrougBuses(): void
    {
        $mockedEvent = $this->createMock(DomainEvent::class);
        $this->syncBusInterface->expects($this->once())
                               ->method('dispatch')
                               ->willReturn(new Envelope($mockedEvent));
        $this->asyncBusInterface->expects($this->once())
                                ->method('dispatch')
                                ->willReturn(new Envelope($mockedEvent));
        $this->sut->sendEvents([$mockedEvent]);
    }
}
