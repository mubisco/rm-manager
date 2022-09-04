<?php

namespace App\Tests\unit\Shared\Domain\Event;

use App\Shared\Domain\Event\PersistibleEventId;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class PersistibleEventIdTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldReturnProperId(): void
    {
        $sut = PersistibleEventId::fromEmpty();
        $this->assertTrue(Uuid::isValid($sut->value()));
    }

    /**
     * @test
     */
    public function itShouldReturnDifferentIdOnEachInstance(): void
    {
        $sut = PersistibleEventId::fromEmpty();
        $anotherSut = PersistibleEventId::fromEmpty();
        $this->assertNotEquals($sut->value(), $anotherSut->value());
    }
    /**
     * @test
     */
    public function itShouldReturnProperIdWhenIdProvided(): void
    {
        $sut = PersistibleEventId::fromString('f2117b51-c799-4806-a429-0646d05d040b');
        $this->assertEquals('f2117b51-c799-4806-a429-0646d05d040b', $sut->value());
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionIfValueProvidedNotValid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        PersistibleEventId::fromString('f2117b51-c7994806-a429-0646d05d040b');
    }
}
