<?php

namespace App\User\Domain;

use PHPUnit\Framework\TestCase;

class UserPasswordTest extends TestCase
{
    public function testShouldThrowExceptionIfValueNotValid(): void
    {
        $this->expectException(WrongPasswordFormatException::class);
        new UserPassword('wrongPassword');
    }

    public function testShouldReturnProperValue(): void
    {
        $sut = new UserPassword('asdasf');
        $this->assertEquals('asdasf', $sut->value());
    }
}
