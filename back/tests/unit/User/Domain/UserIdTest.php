<?php

namespace App\Tests\unit\User\Domain;

use App\User\Domain\UserId;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Ulid;

class UserIdTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldReturnProperValue(): void
    {
        $ulid = new Ulid();
        $sut = UserId::fromString($ulid->__toString());
        $this->assertEquals($ulid, $sut->value());
    }

    /**
     * @test
     */
    public function itShouldReturnProperValueFromEmptyString(): void
    {
        $sut = UserId::fromEmpty();
        $this->assertTrue(Ulid::isValid($sut->value()));
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionIfValueProvidedNotValid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        UserId::fromString('asd');
    }

    /**
     * @test
     */
    public function itShouldReturnFalseIfUserIdNotTheSame(): void
    {
        $sut = UserId::fromEmpty();
        $anotherSut = UserId::fromEmpty();
        $this->assertFalse($sut->equalsTo($anotherSut));
    }

    /**
     * @test
     */
    public function itShouldReturnTrueIfUserIdsHaveSameIds(): void
    {
        $ulid = new Ulid();
        $sut = UserId::fromString($ulid->__toString());
        $anotherSut = UserId::fromString($ulid->__toString());
        $this->assertTrue($sut->equalsTo($anotherSut));
    }
}
