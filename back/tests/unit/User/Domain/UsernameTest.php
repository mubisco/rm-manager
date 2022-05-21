<?php

namespace App\User\Domain;

use PHPUnit\Framework\TestCase;

class UsernameTest extends TestCase
{
    public function testShouldReturnProperUsername(): void
    {
        $sut = new Username('asd');
        $this->assertEquals('asd', $sut->value());
    }

    public function testShouldReturnProperUsernameFromDifferentInstance(): void
    {
        $sut = new Username('username');
        $this->assertEquals('username', $sut->value());
    }

    public function testShouldThowExceptionIfBadUsername(): void
    {
        $this->expectException(WrongUsernameException::class);
        new Username('bad username');
    }

    public function testShouldThowExceptionIfEmtpyUsername(): void
    {
        $this->expectException(WrongUsernameException::class);
        new Username('');
    }
}
