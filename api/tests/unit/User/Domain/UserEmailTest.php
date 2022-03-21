<?php

namespace App\User\Domain;

use PHPUnit\Framework\TestCase;

class UserEmailTest extends TestCase
{
    public function testShouldThrowExceptionIfValueNotValid(): void
    {
        $this->expectException(WrongUserEmailException::class);
        new UserEmail('asdf');
    }

    public function testShouldReturnProperValue(): void
    {
        $sut = new UserEmail('xan@server.net');
        $this->assertEquals('xan@server.net', $sut->value());
    }
}
