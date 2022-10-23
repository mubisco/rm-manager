<?php

namespace App\User\Domain;

use PHPUnit\Framework\TestCase;

class UserPasswordTest extends TestCase
{
    public function testShouldThrowExceptionIfValueNotValid(): void
    {
        $this->expectException(WrongPasswordFormatException::class);
        new UserPassword('anotherPass');
    }

    public function testShouldReturnProperValue(): void
    {
        $sut = new UserPassword('aVeryS3cureP4ssw0rd');
        $this->assertEquals('aVeryS3cureP4ssw0rd', $sut->value());
    }
}
