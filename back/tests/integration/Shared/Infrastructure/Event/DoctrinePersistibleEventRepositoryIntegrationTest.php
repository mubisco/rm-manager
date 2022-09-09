<?php

namespace App\Tests\integration\Shared\Infrastructure\Event;

use App\Shared\Domain\Event\PersistibleEvent;
use App\Shared\Domain\Event\PersistibleEventId;
use App\Shared\Domain\Event\PersistibleEventNotFoundException;
use App\Shared\Domain\Event\PersistibleEventRepository;
use App\Shared\Infrastructure\Event\DoctrinePersistibleEventRepository;
use App\User\Domain\PasswordTokenWasRequested;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DoctrinePersistibleEventRepositoryIntegrationTest extends KernelTestCase
{
    private DoctrinePersistibleEventRepository $sut;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->managerRegistry = $kernel->getContainer()->get('doctrine');
        $this->sut = new DoctrinePersistibleEventRepository($this->managerRegistry);
    }

    /**
     * @test
     */
    public function itShouldBeOfProperClass(): void
    {
        $this->assertInstanceOf(DoctrinePersistibleEventRepository::class, $this->sut);
        $this->assertInstanceOf(PersistibleEventRepository::class, $this->sut);
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionIfNoEventExists(): void
    {
        $this->expectException(PersistibleEventNotFoundException::class);
        $eventId = PersistibleEventId::fromEmpty();
        $this->sut->ofId($eventId);
    }

    /**
     * @test
     */
    public function itShouldInsertProperEntity(): void
    {
        $event = new PasswordTokenWasRequested('2a29e209-6e91-4e75-be03-867d62abe4c1');
        $persistibleEvent = PersistibleEvent::fromDomainEvent($event);
        $result = $this->sut->store($persistibleEvent);
        $this->sut->ofId($persistibleEvent->eventId());
        $this->assertSame($persistibleEvent, $result);
    }
}
