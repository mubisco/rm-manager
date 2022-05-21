<?php

namespace App\Shared\Infrastructure\Event;

use App\User\Domain\PasswordTokenWasRequested;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DoctrineEventStoreTest extends KernelTestCase
{
    private ?ManagerRegistry $managerRegistry;
    private $sut;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->managerRegistry = $kernel->getContainer()->get('doctrine');
        $this->sut = $kernel->getContainer()->get('test.eventStore');
    }

    public function testShouldAppendDomainEvent()
    {
        $testEvent = new PasswordTokenWasRequested('SomeUlid');
        $this->sut->append($testEvent);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        // doing this is recommended to avoid memory leaks
        $entityManager = $this->managerRegistry->getManager();
        $entityManager->clear();
        $this->managerRegistry = null;
    }
}
